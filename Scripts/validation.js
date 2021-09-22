/**
 * Author: Anthony Kakolyris | 103059636
 * Target: addrecord.html
 * Purpose: Validation of form
 * Created: 09/9/2021
 * Last Updated: 20/9/2021
 * Credits: Swinburne University
 */

"use strict";

function validate() {

  var errMsg = "";
  var result = true;

  var itemName = document.getElementById("itemName").value;
  var itemPrice = document.getElementById("itemPrice").value;
  var soh = document.getElementById("soh").value;

  var saleItems = document.getElementById("saleItems").value;
  var salePrice = document.getElementById("salePrice").value;
  var saleDate = document.getElementById("saleDate").value;

  if(isNaN(itemPrice)) {
    errMsg += "The item price must be a number.\n";
    result = false;
  }

  if(isNaN(soh)) {
    errMsg += "The stock amount must be a number.\n";
    result = false;
  }

  if (errMsg != "") {
      alert(errMsg);
  }

  return result;

}

function init() {

  var formValidate = document.getElementById("inputForm");
  formValidate.onsubmit = validate;

}

window.onload = init;
