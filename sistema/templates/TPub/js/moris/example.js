$(function () {

    /* data stolen from http://howmanyleft.co.uk/vehicle/jaguar_'e'_type */
    var day_data = [
        {"period": "Domingo", "curtidas": 72, "usuarios": 90, "brindes": 10},
        {"period": "Segunda", "curtidas": 25, "usuarios": 40, "brindes":12},
        {"period": "Terça", "curtidas": 36, "usuarios": 35, "brindes":17},
        {"period": "Quarta", "curtidas": 30, "usuarios": 39, "brindes":15},
        {"period": "Quinta", "curtidas": 39, "usuarios": 20, "brindes":12},
        {"period": "Sexta", "curtidas": 45, "usuarios": 50, "brindes":32},
        {"period": "Sabado", "curtidas": 67, "usuarios": 65, "brindes":25}
    ];
    Morris.Bar({
        element: 'graph_bar_group',
        data: day_data,
        xkey: 'period',
        barColors: ['#1ABB9C', '#E74C3C', '#3498DB', '#3498DB'],
        ykeys: ['curtidas', 'usuarios', 'brindes'],
        labels: ['Curtidas', 'Usuarios', 'Brindes'],
        hideHover: 'auto',
        xLabelAngle: 60
    });

});