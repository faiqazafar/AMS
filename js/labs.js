// Populates a "Lab" <select> by fetching the labs that actually exist
// in the database for the chosen department (get_labs.php), instead of
// generating a fixed Lab 1..N list in JS.
//
// deptId / labId   : element ids of the department and lab <select> tags
// preselect         : lab value to select once options load (e.g. when
//                      editing an existing asset, or re-showing a filter)
// includeAllOption  : true on filter/view pages -> adds an "All Labs"
//                      option and allows an empty department
function loadLabOptions(deptId, labId, preselect, includeAllOption) {
    var deptEl = document.getElementById(deptId);
    var labSelect = document.getElementById(labId);

    if (!deptEl || !labSelect) {
        return;
    }

    var dept = deptEl.value;
    labSelect.innerHTML = '';

    if (includeAllOption) {
        var allOpt = document.createElement('option');
        allOpt.value = '';
        allOpt.textContent = 'All Labs';
        labSelect.appendChild(allOpt);
    }

    if (!dept) {
        return;
    }

    fetch('get_labs.php?department=' + encodeURIComponent(dept))
        .then(function (res) { return res.json(); })
        .then(function (data) {
            var labs = data.labs || [];

            labs.forEach(function (lab) {
                var opt = document.createElement('option');
                opt.value = lab;
                opt.textContent = lab;
                labSelect.appendChild(opt);
            });

            if (preselect) {
                labSelect.value = preselect;
            }
        })
        .catch(function () {
            // Leave whatever options are already there (e.g. "All Labs")
            // if the request fails, rather than breaking the form.
        });
}
