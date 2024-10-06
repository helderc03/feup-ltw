function applyFilter() {
    clearFilters();
    var departmentSelect = document.getElementById('filterDepartment');
    var department = departmentSelect.value;
    var statusSelect = document.getElementById('filterStatus');
    var status = statusSelect.value;
    var assigneeSelect = document.getElementById('filterAssignee');
    var assignee = assigneeSelect.value;
    var selectedHashtags = Array.from(document.querySelectorAll('#tags option:checked')).map(option => option.value);
    console.log(selectedHashtags);
    var tickets = document.getElementsByClassName('ticket');

    for (var i = 0; i < tickets.length; i++) {
        var ticketDepartment = tickets[i].getAttribute('data-department');
        var ticketStatus = tickets[i].getAttribute('data-status');
        var ticketAssignee = tickets[i].getAttribute('data-assignee');
        var ticketHashtags = tickets[i].getAttribute('data-hashtags').split(',');
        console.log(ticketHashtags);
        var departmentMatch = department === '' || ticketDepartment === department;
        var statusMatch = status === '' || ticketStatus === status;
        var assigneeMatch = assignee === ''  || ticketAssignee === assignee;
        var hashtagMatch = selectedHashtags.length === 0 || selectedHashtags.some(hashtag => ticketHashtags.includes(hashtag));

        if (departmentMatch && statusMatch && assigneeMatch && hashtagMatch) {
            tickets[i].style.display = 'auto'; 
        } else {
            tickets[i].style.display = 'none'; 
        }
    }
}


function clearFilters() {
    var tickets = document.getElementsByClassName('ticket');
    for (var i = 0; i < tickets.length; i++) {
        tickets[i].style.display = '';
    }   

}

function toggleSidebar() {
    var sidebar = document.querySelector('.filter-sidebar');
    sidebar.classList.toggle('sidebar-show');
  }
  function closeSidebar() {
    var sidebar = document.querySelector('.filter-sidebar');
    sidebar.classList.remove('sidebar-show');
}