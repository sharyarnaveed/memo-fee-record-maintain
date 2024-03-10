// aside buttons
let main_section = document.querySelector(".main-section");
let memo_button = document.getElementById("memo_button");
let dashboard_button = document.getElementById("dashboard_button");
let title = document.getElementById("title");
let feesubmit_button = document.getElementById("fee_submit_button");

// for dashboard open

async function fetch_dashboard()
{
  try {
    let dashboard_fe=await fetch("main.php");
    let dashboard=await dashboard_fe.text();

    return dashboard;
  } catch (error) {
    
console.error("Error Fetching dashboard ");
throw new error;

  }
}

dashboard_button.addEventListener("click", async() => {
let fetchdashboard=await fetch_dashboard();
main_section.innerHTML=fetchdashboard;

});

// ajax for fee submit


// ajax for memo option
async function memo_open() {
  try {
    let memofect = await fetch("memo.php");
    let data = await memofect.text();
    return data;
  } catch (error) {
    console.error("error fetching memo.html ");
    throw error;
  }
}

memo_button.addEventListener("click", async () => {
  let memoopen = await memo_open();
  main_section.innerHTML = memoopen;
  title.innerHTML = "Memo";

  //   to add memo

  });







// for to-do list

let todo_button=document.getElementById("todo_button");


async function fetch_todo()
{
  try {
    let todo=await fetch("to-do_list.html");
    let fetched=await todo.text();

    return fetched;
  } catch (error) {
    console.error("Error Fetching To-DO");
    throw new error;
  }
}




todo_button.addEventListener("click",async()=>
{
  let fetchtodo=await fetch_todo();
  main_section.innerHTML=fetchtodo;

let task=document.getElementById("to_to_input");
let add=document.getElementById("to_do_submit");
add.addEventListener('click', ()=>
{
  let data=task.value;
console.log(data);
})

})

