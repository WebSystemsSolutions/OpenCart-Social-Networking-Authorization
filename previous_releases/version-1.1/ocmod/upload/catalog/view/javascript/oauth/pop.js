var googleWindow;


function OpenPopupCenter(pageURL, title, w, h) {

    var left = (screen.width - w) / 2;

    var top = (screen.height - h) / 4;

    googleWindow = window.open(pageURL, title, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, copyhistory=no, width=' + w + ', height=' + h + ', top=' + top + ', left=' + left);

    //closeWin();

}


function closeWin() {
    googleWindow.close();   // Closes the new window
}