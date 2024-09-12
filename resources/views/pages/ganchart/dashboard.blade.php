<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
<<<<<<< HEAD
    <title>Weekly Gantt Chart with PDF Export</title>
    <link rel="stylesheet" href="https://cdn.dhtmlx.com/gantt/edge/dhtmlxgantt.css">
    <script src="https://cdn.dhtmlx.com/gantt/edge/dhtmlxgantt.js"></script>
    <!-- Add html2canvas and jsPDF for exporting to PDF -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.2/jspdf.min.js"></script>
    <style>
        /* Custom styles for printing */
        @media print {
            #gantt_here {
                width: 100%;
                height: auto;
            }
        }
        /* Ensure the Gantt chart fills the screen */
        #gantt_here {
            width: 100%;
            height: 600px;
        }
    </style>
</head>
<body>

    <h2>Weekly Gantt Chart Example</h2>

    <!-- Button to trigger PDF export -->
    <button id="export_pdf">Export to PDF</button>

    <!-- Gantt chart container -->
    <div id="gantt_here"></div>

    <script>
        // Initialize the Gantt chart
        gantt.config.date_format = "%Y-%m-%d";

        // Configure scales for months and weeks
        gantt.config.scale_unit = "month";
        gantt.config.date_scale = "%F %Y";

        // Sub-scale for weeks (Week 1-4 in each month)
=======
    <title>Weekly Gantt Chart</title>
    <link rel="stylesheet" href="https://cdn.dhtmlx.com/gantt/edge/dhtmlxgantt.css">
    <script src="https://cdn.dhtmlx.com/gantt/edge/dhtmlxgantt.js"></script>
</head>
<body>
    <h2>Weekly Gantt Chart Example</h2>

    <div id="gantt_here" style="width:100%; height:500px;"></div>

    <script>
        
        gantt.config.date_format = "%Y-%m-%d";

        // Konfigurasi Gantt Chart
        gantt.config.scale_unit = "month"; // Unit utama skala adalah bulan
        gantt.config.date_scale = "%F %Y"; // Tampilkan nama bulan dan tahun (Januari 2024, dst.)

        // Sub skala untuk minggu 1-4 di setiap bulan
>>>>>>> 28164a9d5f8d90fb6349e9f8740e599413e7bcf5
        gantt.config.subscales = [
            {
                unit: "week", step: 1, template: function(date){
                    var weekNum = gantt.date.getWeek(date);
                    var monthStartWeek = gantt.date.getWeek(gantt.date.month_start(date));
                    var weekInMonth = weekNum - monthStartWeek + 1;

<<<<<<< HEAD
                    // Limit to Week 1-5, if week 5 exists
                    if (weekInMonth < 1 || weekInMonth > 5) {
                        return "Week 1";
=======
                    // Batasi hanya hingga minggu 4
                    if (weekInMonth < 1 || weekInMonth > 4) {
                        return "";
>>>>>>> 28164a9d5f8d90fb6349e9f8740e599413e7bcf5
                    }
                    return "Week " + weekInMonth;
                }
            }
        ];

<<<<<<< HEAD
        gantt.config.scale_height = 60; // Scale height (header)
        gantt.config.row_height = 30;   // Row height
        gantt.config.bar_height = 20;   // Bar height

        // Set the start and end date limits for the chart
        var currentYear = new Date().getFullYear();
        gantt.config.start_date = new Date(currentYear, 0, 1); // Start of January
        gantt.config.end_date = new Date(currentYear, 11, 31); // End of December

        gantt.init("gantt_here");

        // Sample data for Gantt chart
        gantt.parse({
            data: [
                {id: 1, text: 'Activity 1', start_date: '2024-02-08', end_date: '2024-04-08', type: 'plan'},
                {id: 2, text: 'Activity 2', start_date: '2024-01-15', end_date: '2024-02-12', type: 'plan'},
                // Overlay actuals for the same activities
                {id: 1, text: 'Activity 1 (Actual)', start_date: '2024-02-15', end_date: '2024-04-15', type: 'actual'},
                {id: 2, text: 'Activity 2 (Actual)', start_date: '2024-01-20', end_date: '2024-02-18', type: 'actual'}
            ]
        });

        // Modify the appearance of the actual tasks to have less opacity
        gantt.templates.task_class = function(start, end, task) {
            if (task.type === 'actual') {
                return "actual-task";
            }
            return "";
        };

        // Custom CSS for the actual task (overlay) with reduced opacity
        var style = document.createElement('style');
        style.innerHTML = `
            .actual-task .gantt_task_line {
                stroke-width: 2;
                fill-opacity: 0.5;
                stroke-opacity: 0.5;
            }
        `;
        document.head.appendChild(style);

        // PDF export functionality using html2canvas and jsPDF
        document.getElementById("export_pdf").onclick = function() {
            html2canvas(document.getElementById('gantt_here'), {
                useCORS: true,
                onrendered: function(canvas) {
                    var imgData = canvas.toDataURL('image/png');
                    var pdf = new jsPDF('l', 'pt', [canvas.width, canvas.height]);
                    pdf.addImage(imgData, 'PNG', 0, 0, canvas.width, canvas.height);
                    pdf.save('gantt_chart.pdf');
                }
            });
        };
=======
        gantt.config.scale_height = 60; // Tinggi skala (header)
        gantt.config.row_height = 30;   // Tinggi setiap baris aktivitas
        gantt.config.bar_height = 20;   // Tinggi bar Gantt untuk setiap aktivitas

        // Batasi tampilan Gantt Chart hingga Desember
        gantt.config.start_date = new Date(2024, 0, 1); // 1 Januari 2024
        gantt.config.end_date = new Date(2024, 11, 31); // 31 Desember 2024

        gantt.init("gantt_here");

  
        gantt.parse({
            data: [
                @foreach($activities as $activity)
                    {
                        id: '{{ $activity['id'] }}',
                        text: '{{ $activity['text'] }}',
                        start_date: '{{ $activity['start_date'] }}',
                        end_date: '{{ $activity['end_date'] }}',
                    },
                @endforeach
            ]
        });
>>>>>>> 28164a9d5f8d90fb6349e9f8740e599413e7bcf5
    </script>

</body>
</html>
