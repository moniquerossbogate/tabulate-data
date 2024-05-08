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

<div class="container-fluid">

    <div class="row">
        <div class="col-12">
            <!-- Calendar -->
            <div class="card card-primary">
                <div class="card-header border-0">

                    <h3 class="card-title">
                        <i class="far fa-calendar-alt"></i>
                        Number of Respondents per Questions
                    </h3>
                    <!-- tools card -->
                    <div class="card-tools">
                        <!-- button with a dropdown -->

                        <button type="button" class="btn btn-sm" data-card-widget="collapse" style="color:white">
                            <i 
                            class="fas fa-minus"></i>
                        </button>
                        <button type="button" class="btn  btn-sm" data-card-widget="remove" style="color:white">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    <!-- /. tools -->
                </div>
                <div class="col-md-4" style="padding-top: 10px;">
                    <?php
                    echo Select2::widget([
                        'name' => 'state_10',
                        'data' => ArrayHelper::map($titles, 'id', 'title'),
                        'options' => [
                            'id' => 'question-select',
                            // Added id attribute
                            'placeholder' => 'Please Select Questions',
                            'multiple' => false,
                            'value' => 1,
                        ],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
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

                </div>


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
$this->registerJsVar('selectedValuesToIndices', [1, 2, 3, 4, 5, 6]);
$this->registerJsVar('countData1', json_encode($question1Counts)); // Encode $question1Counts to JSON format
$this->registerJsVar('countData2', json_encode($question2Counts)); // Encode $question2Counts to JSON format
$this->registerJsVar('countData3', json_encode($question3Counts)); // Encode $question3Counts to JSON format
$this->registerJsVar('countData4', json_encode($question4Counts));
$this->registerJsVar('countData5', json_encode($question5Counts));
$this->registerJsVar('countData6', json_encode($question6Counts));

$this->registerJs(
    <<<JS
    (function () {
        function showQuestions(selectedQuestionId) {
            console.log('Showing questions for Question ID:', selectedQuestionId);
            // Hide all questions
            $('.question').hide();
            console.log('Number of questions:', $('.question').length);
            // Show questions corresponding to the selected title
            $('.question').each(function () {
                console.log('Question ID:', $(this).data('question-id'));
                if ($(this).data('question-id') == selectedQuestionId) {
                    $(this).show();
                    console.log('Question with ID', selectedQuestionId, 'is shown');
                }
            });
        }

        var ctx = document.getElementById('myChart').getContext('2d');
        let chart;

        function updateChart(selectedQuestionId) {
            console.log('Selected Question ID:', selectedQuestionId);
            const selectedIndex = selectedValuesToIndices.indexOf(parseInt(selectedQuestionId));
            console.log('Selected Index:', selectedIndex);
            if (selectedIndex !== -1) {
                let counts;
                if (selectedIndex === 0) {
                    counts = JSON.parse(countData1);
                } else if (selectedIndex === 1) {
                    counts = JSON.parse(countData2);
                } else if (selectedIndex === 2) {
                    counts = JSON.parse(countData3);
                } else if (selectedIndex === 3 ) {
                    counts = JSON.parse(countData4);
                } else if (selectedIndex === 4 ) {
                    counts = JSON.parse(countData5);
                } else if (selectedIndex === 5 ) {
                    counts = JSON.parse(countData6);
                }
                console.log('Counts:', counts);
                const countDataArray = typeData.map(option => counts[option] || 0); // Map counts for typeData
                console.log('Count Data:', countDataArray);
                chart.data.datasets[0].data = countDataArray; // Update chart data
                chart.update(); // Update the chart
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

        // Dropdown change event listener
        $('#question-select').on('change', function () {
            console.log('Dropdown changed');
            const selectedQuestionId = $(this).val();
            console.log('Selected Question ID:', selectedQuestionId);
            if (selectedQuestionId === "") {
                // Reset chart
                chart.data.datasets[0].data = [0, 0, 0, 0];
                chart.update();
            } else {
                // Hide all questions
                $('#question-container > div').hide();
                // Show selected questions
                $('#questions-' + selectedQuestionId).show();
                updateChart(selectedQuestionId);
            }
        });

        // AJAX request to fetch questions
        $('#question-select').on('change', function() {
            const selectedTitle = $(this).val();
                if (selectedTitle) {
                $.ajax({
                    url: 'questions',
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