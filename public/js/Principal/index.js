$(document).ready(function() {
    /* DataTables */
    mountDataTable('#listEntity', 'Explore', 'ListEntity');
    mountDataTable('#listVEntity', 'Explore', 'ListVEntity');
    mountDataTable('#listDao', 'Explore', 'ListDao');
    mountDataTable('#listLogic', 'Explore', 'ListLogic');
});