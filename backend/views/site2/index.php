<?php

use app\models\Questionnaire;
use kartik\select2\Select2;
use yii\bootstrap4\Html;
use yii\helpers\ArrayHelper;
use app\assets\ChartJsAsset;

/** @var yii\web\View $this */
$titles = Questionnaire::getQuestions();
$this->title = 'Tabulate Data';
?>
<style>
    .question {
        margin-right: 10px;
        /* Adjust this value as needed */
    }
</style>
    <div>Total Count of Respondents: <span id="total-count"></span>/<span>120</span></div>
                    <div class="col-md-8" style="padding-top: 10px">
                        <?php
                            echo Select2::widget([
                                'name' => 'state_10',
                                'data' => ArrayHelper::map($titles, 'id', 'title'),
                                'options' => [
                                   'id' => 'question-select',
                                    'placeholder' => 'Please Select Question',
                                    'multiple' => false,
                                    'value' => 1,
                                ],
                                'pluginOptions' => [
                                    'allowClear' => true
                                ]
                            ]);
                        ?>

                    </div>

                <canvas id="myChart" width="400" height="100"></canvas>
                <!-- ./card-body -->
                <!-- 
                <div class="card-footer">
                    <div class="question row" id="question-container">

                    </div>
                </div> -->
                
                 
                <div class="card-footer">
                    <div class="row">
                        <div class="col-sm-3 col-6">
                            <div class="description-block border-right" style="margin-left: 20px;" id="question-container1">

                            </div>
                        </div>
                        <div class="col-sm-3 col-6">
                            <div class="description-block border-right" style="margin-left: 20px;" id="question-container2">

                            </div>
                        </div>
                        <div class="col-sm-3 col-6">
                            <div class="description-block border-right" style="margin-left: 20px;" id="question-container3">

                            </div>
                        </div>
                        <div class="col-sm-3 col-6">
                            <div class="description-block border-right" style="margin-left: 20px;" id="question-container4">

                            </div>
                        </div>
                    </div>

                <!-- <div class="col-md-4" style="padding-top: 10px;">
                <button type="button" id="question-select" class="btn btn-primary">Next Question</button>
                </div>
                <div>Total Count of Respondents: <span id="total-count"></span></div> -->

                <!-- /.row -->
            </div>
            <!-- /.card-footer -->
        </div>

        <!-- /.card -->

    </div>
</div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0"></script>
<?php
// Assuming $typeData is an array containing your chart data
    $this->registerJsVar('typeData', ["A", "B", "C", "D"]);
    $this->registerJsVar('countData', json_encode($questionCounts)); 
    $questionIds = array_keys($questionCounts);
    $this->registerJsVar('selectedValuesToIndices', $questionIds);
    
    
    $this->registerJs(
        <<<JS
        (function () {
        
            var ctx = document.getElementById('myChart').getContext('2d');
            let chart;
            
         // Add this function to calculate total count
        function calculateTotalCount(counts) {
            return Object.values(counts).reduce((acc, val) => acc + val, 0);
        }

    // Add a variable to hold the maximum number of respondents allowed
        const maxRespondentsLimit = 120; // Adjust this value as needed

        // Update the updateChart function to calculate total count, apply limit, and update chart data
        function updateChart(selectedQuestionId) {
        const selectedIndex = selectedValuesToIndices.indexOf(parseInt(selectedQuestionId));
        if (selectedIndex !== -1) {
            const counts = JSON.parse(countData);

        // Calculate total count
        const totalCount = calculateTotalCount(counts[selectedQuestionId]);

        // Apply limit if total count exceeds the maximum limit
        const limitedTotalCount = totalCount > maxRespondentsLimit ? maxRespondentsLimit : totalCount;

        // Update total count display
        $('#total-count').text(limitedTotalCount);

        // Calculate count data array
        const countDataArray = typeData.map(option => {
            const count = counts[selectedQuestionId][option] || 0;
            // Apply percentage calculation based on limited total count
            return (count / limitedTotalCount) * 120;
        });

            chart.data.datasets[0].data = countDataArray;
            chart.update();
        } else {
            console.log('Selected Question ID not found in mapping.');
        }
    }

            // Initial chart setup
            chart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: typeData,
                datasets: [{
                    label: 'Count of Respondents per Question',
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 205, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                    ],
                    borderColor: [
                        'rgb(255, 99, 132)',
                        'rgb(54, 162, 235)',
                        'rgb(255, 205, 86)',
                        'rgb(75, 192, 192)',
                    ],
                borderWidth: 1,
                datalabels: {
                    color: 'red',
                    font: {
                        size: 20
                    },
                    formatter: function(value, context) {
                        return value.toFixed(2) + '%'; // Formats the label with two decimal places and adds the percentage sign
                    }
                }
            }]
        },
            options: {
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            },
            plugins: [ChartDataLabels],
            options: {

            }
        });

        $('#question-select').on('change', function(){
            const selectedQuestionId = $(this).val();
            if (selectedQuestionId === ''){
                chart.data.datasets[0].data = [0, 0, 0, 0];
                chart.update();
            }else{
                updateChart(selectedQuestionId);
            }
        })


        // AJAX request to fetch questions
        $('#question-select').on('change', function() {
            const selectedTitle = $(this).val();
                if (selectedTitle) {
                $.ajax({
                      url: 'site/questions',
                    type: 'GET',
                    data: { titleId: selectedTitle },
                    success: function(response) {
                        $('#question-container').empty();
                        $('.description-block').show();
                        if (Array(response)) {
                                const regex = /[^\w\s,]/g; 
                                questionText = response.replace(regex, ''); 
                                let wordsArray = questionText.split(',');
                                wordsArray = wordsArray.map(word => word.trim());
                                console.log('text:', wordsArray);
                                //this is the line to populate the data by column
                                for (let i = 1; i <= wordsArray.length; i++) {
                                let container = document.getElementById("question-container" + i);
                                if (container) { // Check if the container exists
                                    container.textContent = wordsArray[i - 1];
                                }
                            }
                            }else {
                            console.error('Unexpected response format:', response);
                            $('#question-container').text('Error: Unexpected response format');
                        }
                    },
                error: function(xhr, status, error) {
                    console.error('AJAX Error:', xhr.responseText);
                }
                });
            } else {
                $('.description-block').hide();
            }
        });


    })();
JS
);
?>



<script>
// JavaScript to handle Select2 change event
</script>