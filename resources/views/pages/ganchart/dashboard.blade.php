<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
        gantt.config.subscales = [
            {
                unit: "week", step: 1, template: function(date){
                    var weekNum = gantt.date.getWeek(date);
                    var monthStartWeek = gantt.date.getWeek(gantt.date.month_start(date));
                    var weekInMonth = weekNum - monthStartWeek + 1;

                    // Batasi hanya hingga minggu 4
                    if (weekInMonth < 1 || weekInMonth > 4) {
                        return "";
                    }
                    return "Week " + weekInMonth;
                }
            }
        ];

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
    </script>

</body>
</html>
