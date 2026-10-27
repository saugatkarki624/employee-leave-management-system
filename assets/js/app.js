// Global JS. jQuery is loaded before this file.
$(function () {
  // Auto-hide success alerts after 4 seconds
  setTimeout(function () { $('.alert-success').alert('close'); }, 4000);
});
