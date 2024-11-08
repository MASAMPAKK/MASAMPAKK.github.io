function showSection(sectionId) {
    const sections = document.querySelectorAll('.section');
    sections.forEach(section => section.style.display = 'none');
    document.getElementById(sectionId).style.display = 'block';
}

    document.addEventListener("DOMContentLoaded", function() {
        const urlParams = new URLSearchParams(window.location.search);
        const section = urlParams.get('section');
        
        if (section) {
            showSection(section); 
        } else {
            showSection('daftar-registrasi'); 
        }
    });


function confirmLogout() {
    if (confirm("Apakah Anda yakin ingin logout?")) {
        window.location.href = "logout.php"; 
    }
}

function liveSearchRegistrasi() {
    var input = document.getElementById("searchRegistrasiInput");
    var filter = input.value.toLowerCase();
    var table = document.getElementById("registrasiTable");
    var tr = table.getElementsByTagName("tr");

    for (var i = 1; i < tr.length; i++) {
        var tdName = tr[i].getElementsByClassName("registrasi-name")[0];
        var tdEmail = tr[i].getElementsByClassName("registrasi-email")[0];
        var tdEvent = tr[i].getElementsByClassName("registrasi-event")[0];

        if (tdName || tdEmail || tdEvent) {
            var txtValueName = tdName.textContent || tdName.innerText;
            var txtValueEmail = tdEmail.textContent || tdEmail.innerText;
            var txtValueEvent = tdEvent.textContent || tdEvent.innerText;

            if (txtValueName.toLowerCase().indexOf(filter) > -1 ||
                txtValueEmail.toLowerCase().indexOf(filter) > -1 ||
                txtValueEvent.toLowerCase().indexOf(filter) > -1) {
                tr[i].style.display = "";
            } else {
                tr[i].style.display = "none";
            }
        }
    }
}

function liveSearch() {
    var input = document.getElementById("searchInput");
    var filter = input.value.toLowerCase(); 
    var table = document.getElementById("eventTable");
    var tr = table.getElementsByTagName("tr"); 

    for (var i = 1; i < tr.length; i++) {
        var tdName = tr[i].getElementsByClassName("event-name")[0]; 
        var tdStatus = tr[i].getElementsByClassName("event-status")[0]; 

        if (tdName || tdStatus) {

            var txtValueName = tdName.textContent || tdName.innerText;
            var txtValueStatus = tdStatus.textContent || tdStatus.innerText;

            if (txtValueName.toLowerCase().indexOf(filter) > -1 || 
                txtValueStatus.toLowerCase().indexOf(filter) > -1) {
                tr[i].style.display = ""; 
            } else {
                tr[i].style.display = "none";
            }
        }
    }
}
