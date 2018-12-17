var
  resetBtnId = '#get-json',
  clearTextId = '#clear-text',
  resetJsonUrl = 'https://jsonplaceholder.typicode.com/posts',
  resetJsonContainer = '#json-display',
  alertMessage = 'There was an error with Ajax request',
  strTemplate = _.template("<li>User ID: <%= userId %>, Text: <%= body %></li>");


function resetJsonError() {
  window.alert(alertMessage);
}

function retJsonSuccessCb(item) {
  var
    text = strTemplate(item);

  $(resetJsonContainer)
    .append(text);
}

function clearResetContainer() {
  $(resetJsonContainer)
    .empty();
}

function resetJsonSuccess(data) {
  clearResetContainer();
  _.each(data, retJsonSuccessCb);
}

function makeAjaxRequest() {
  $.ajax({
    method: 'GET',
    type: 'GET',
    url: resetJsonUrl,
    error: resetJsonError,
    success: resetJsonSuccess
  });
}

function resetJsonClicked() {
  makeAjaxRequest();
}

function applyResetBtnHandler() {
  $(resetBtnId)
    .off('click')
    .on('click', resetJsonClicked);
}

function clearBtnClicked() {
  clearResetContainer();
}

function applyClearBtnHandler() {
  $(clearTextId)
    .off('click')
    .on('click', clearBtnClicked);
}

function init() {
  applyResetBtnHandler();
  applyClearBtnHandler();
}

$(document).ready(init);