
function setFocus1(i)
{
 selectLayer1(i);
}
function selectLayer1(i)
{
 switch(i)
 {
 case 1:
 document.getElementById("focusPic1").style.display="block";
 document.getElementById("focusPic2").style.display="none";
 document.getElementById("focusPic3").style.display="none";
 document.getElementById("focusPic4").style.display="none";
 document.getElementById("focusPic5").style.display="none";
 break;
 case 2:
 document.getElementById("focusPic1").style.display="none";
 document.getElementById("focusPic2").style.display="block";
 document.getElementById("focusPic3").style.display="none";
 document.getElementById("focusPic4").style.display="none";
 document.getElementById("focusPic5").style.display="none";
 break;
 case 3:
 document.getElementById("focusPic1").style.display="none";
 document.getElementById("focusPic2").style.display="none";
 document.getElementById("focusPic3").style.display="block";
 document.getElementById("focusPic4").style.display="none";
 document.getElementById("focusPic5").style.display="none";
 break;
 case 4:
 document.getElementById("focusPic1").style.display="none";
 document.getElementById("focusPic2").style.display="none";
 document.getElementById("focusPic3").style.display="none";
 document.getElementById("focusPic4").style.display="block";
 document.getElementById("focusPic5").style.display="none";
 break;

 }
}