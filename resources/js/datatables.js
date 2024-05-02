// import DataTable from 'datatables.net-bs5';
import DataTable from 'datatables.net-dt';
// import 'datatables.net-responsive-dt';

let table = new DataTable('#mytable', {
    // config options...
    responsive: true,
    // dom: "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6 text-end'f>>" +
    //     "<'row'<'col-sm-12'tr>>" +
    //     "<'row'<'col-sm-12 col-md-5 'i><'col-sm-12 col-md-7 float-end'p>>",
});

// let table = new DataTable('#mytable', {
//     // config options...
//     responsive: true,
//     dom: 
//     "<'row'<'col-sm-12 col-md-6 'l><'col-sm-12 col-md-6 float-md-end'f>>" +
//     "<'row'<'col-sm-12'tr>>" +
//     "<'row'<'col-sm-12 col-md-5 'i><'col-sm-12 col-md-7 float-md-end'p>>",
// });