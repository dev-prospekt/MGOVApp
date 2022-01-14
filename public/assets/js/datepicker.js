$(function() {
  'use strict';

  if($('#datePickerExample').length) {
    var date = new Date();
    var today = new Date(date.getFullYear(), date.getMonth(), date.getDate());
    $('#datePickerExample').datepicker({
      format: "mm/dd/yyyy",
      todayHighlight: true,
      autoclose: true,
      language: 'hr',
      orientation: "bottom",
    });
    $('#datePickerExample').datepicker('setDate', today);
  }
});