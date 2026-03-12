function confirmSubmit(){ return confirm("Are you sure?"); }
function searchPatient(){
  let input=document.getElementById("search").value.toUpperCase();
  let table=document.getElementById("patientTable");
  let tr=table.getElementsByTagName("tr");
  for(let i=1;i<tr.length;i++){
    let td=tr[i].getElementsByTagName("td")[1];
    tr[i].style.display=td && td.innerText.toUpperCase().includes(input)? "":"none";
  }
}