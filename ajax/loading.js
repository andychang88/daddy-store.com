xajax.realCall = xajax.call;
xajax.call = 
function(fName, args1, args2)
{
    xajax.$('loadingMessage').style.display = 'block';

/*
if you wish diff loadingMessages
    if (fName == 'rl1')
    {
        xajax.$('loadingMessage').style.display = 'block';
    } 
    
    if (fName == 'addTowns')
    {
        xajax.$('loadingMessage2').style.display = 'block';
    }
*/
    xajax.realCall(fName, args1, args2);
};

function hideLoadingMessage()
{
    xajax.$('loadingMessage').style.display = 'none';
    xajax.$('loadingMessage2').style.display = 'none';
}
xajax.eventFunctions.globalRequestComplete = hideLoadingMessage;

