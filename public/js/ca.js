
function toggleTable(tableId, button) {

    const table = document.getElementById(tableId);
    // if button selected remove active
    if(button.classList.contains('active')){
        button.classList.remove('active');
    }else{
    // else button selected add active
        button.classList.add('active');
    }

    table.classList.toggle('d-none');
}

document.getElementById('prevWeek').addEventListener('click', function () {
    adjustWeek(-7);
});

document.getElementById('nextWeek').addEventListener('click', function () {
    adjustWeek(7);
});

function adjustWeek(days) {
    let startDate = document.getElementById('startDate');
    let endDate = document.getElementById('endDate');

    let start = new Date(startDate.value || new Date());
    let end = new Date(endDate.value || new Date());

    start.setDate(start.getDate() + days);
    end.setDate(end.getDate() + days);

    startDate.value = start.toISOString().split('T')[0];
    endDate.value = end.toISOString().split('T')[0];
}
