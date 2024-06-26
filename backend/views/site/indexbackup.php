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
                            <i class="fas fa-minus"></i>
                        </button>
                        <button type="button" class="btn  btn-sm" data-card-widget="remove" style="color:white">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    <!-- /. tools -->
                </div>

                <div class="selected-question-container">
                    Selected Question: <span id="selected-question"></span>
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
                            <div class="description-block border-right" style="margin-left: 20px;"
                                id="question-container1">

                            </div>
                        </div>
                        <div class="col-sm-3 col-6">
                            <div class="description-block border-right" style="margin-left: 20px;"
                                id="question-container2">

                            </div>
                        </div>
                        <div class="col-sm-3 col-6">
                            <div class="description-block border-right" style="margin-left: 20px;"
                                id="question-container3">

                            </div>
                        </div>
                        <div class="col-sm-3 col-6">
                            <div class="description-block border-right" style="margin-left: 20px;"
                                id="question-container4">

                            </div>
                        </div>
                    </div>

                    <div class="col-md-4" style="padding-top: 10px;">
                        <button type="button" id="question-select" class="btn btn-primary">Next Question</button>
                    </div>
                    <div>Total Count of Respondents: <span id="total-count"></span></div>

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
$this->registerJsVar('selectedValuesToIndices', [1, 2, 3,]);
$this->registerJsVar('countData1', json_encode($question1Counts)); // Encode $question1Counts to JSON format
$this->registerJsVar('countData2', json_encode($question2Counts)); // Encode $question2Counts to JSON format
$this->registerJsVar('countData3', json_encode($question3Counts)); // Encode $question3Counts to JSON format

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
        const selectedIndex = selectedValuesToIndices.indexOf(parseInt(selectedQuestionId));
        if (selectedIndex !== -1) {
            let counts;
            if (selectedIndex === 0) {
                counts = JSON.parse(countData1);
            } else if (selectedIndex === 1) {
                counts = JSON.parse(countData2);
            } else if (selectedIndex === 2) {
                counts = JSON.parse(countData3);
            } else if (selectedIndex === 3) {
                // Add similar handling for other questions if needed
            }

        // Calculate total count for the selected question
        const totalCount = Object.values(counts).reduce((acc, val) => acc + val, 0);

        // Calculate percentages and map them to the typeData
        const percentageDataArray = typeData.map(option => ((counts[option] || 0) / totalCount) * 120);

        chart.data.datasets[0].data = percentageDataArray; // Update chart data with percentages
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


    (function () {
    let currentQuestionIndex = 0; // Track the current question index

    function updateChartAndQuestion() {
        const selectedQuestionId = selectedValuesToIndices[currentQuestionIndex];
        updateChart(selectedQuestionId);
        showQuestions(selectedQuestionId);
        // Update question title
        const selectedQuestionText = typeData[selectedQuestionId - 1]; // Assuming typeData contains the question text
        $('#selected-question').text(selectedQuestionText); // Update selected question text
        const selectedIndex = selectedValuesToIndices.indexOf(parseInt(selectedQuestionId));
            let totalCount = 0;
            if (selectedIndex !== -1) {
                const counts = selectedIndex === 0 ? JSON.parse(countData1) : 
                              selectedIndex === 1 ? JSON.parse(countData2) : 
                              selectedIndex === 2 ? JSON.parse(countData3) : {};

                totalCount = Object.values(counts).reduce((acc, val) => acc + val, 0);
            }

            // Update total count display
            $('#total-count').text(totalCount);
        
    }

    // Event listener for the "Next Question" button
    $('#question-select').on('click', function () {
        currentQuestionIndex++; // Increment the question index
        if (currentQuestionIndex >= selectedValuesToIndices.length) {
            currentQuestionIndex = 0; // Reset index if reached the end
        }
        updateChartAndQuestion();
    });

    // Initial setup
    updateChartAndQuestion();
})();
    
      
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