// Dom Ready
$(function() {
    datatables_columns = [{
        field: "id",
        title: "ID",
        width: 50,
        textAlign: "center",
        sortable: 'asc',
        filterable: !1,
    }, {
        field: "uid",
        title: "Author",
        type: "date",
        textAlign: "center"
    }, {
        field: "module",
        title: "Module",
        width: 150
    }, {
        field: "action",
        title: "Thao tác",
        width: 300
    }, {
        field: "note",
        title: "Note",
        type: "date",
        textAlign: "center"
    }, {
        field: "created_time",
        title: "Created Time",
        type: "date",
        textAlign: "center",
        format: "MM/DD/YYYY"
    }];
    AJAX_DATATABLES.init();
});
