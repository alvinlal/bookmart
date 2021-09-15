const datalists = document.querySelectorAll(".dropdown-datalist");

datalists.forEach(datalist => {
  var typingTimer;
  const input = datalist.querySelector(".form-datalist");
  const dropdown = datalist.querySelector(".dropdown-datalist-content");
  const idInput = datalist.querySelector("#idfield");
  const spinner = datalist.querySelector("#spinner-datalist");
  const error = datalist.querySelector(".error-holder");
  const endpoint = idInput.getAttribute("endpoint");

  input.addEventListener("keyup", e => {
    spinner.classList.add("spinning-datalist");
    idInput.setAttribute("hasError", "true");
    error.innerHTML = "";
    input.style.border = "1px solid #969191";

    clearTimeout(typingTimer);
    typingTimer = setTimeout(() => {
      if (input.value) {
        try {
          fetch(`/${endpoint}?q=${encodeURIComponent(input.value.trim())}`)
            .then(response => response.json())
            .then(list => {
              dropdown.style.display = "flex";
              if (list.results) {
                if (error.innerHTML) {
                  input.style.border = "1px solid #969191";
                  error.innerHTML = "";
                }
                dropdown.innerHTML = "";
                for (let i = 0; i < list.data.length; i++) {
                  const div = document.createElement("div");
                  div.classList.add("dropdown-datalist-item");
                  div.innerHTML = list.data[i].result;
                  if (list.data[i].result == input.value.toLowerCase()) {
                    idInput.setAttribute("hasError", "false");
                    dropdown.style.display = "none";
                    idInput.value = list.data[i].id;
                    spinner.classList.remove("spinning-datalist");
                    break;
                  }
                  div.addEventListener("click", () => {
                    idInput.setAttribute("hasError", "false");
                    input.value = list.data[i].result.split(">")[0];
                    idInput.value = list.data[i].id;
                    dropdown.style.display = "none";
                  });
                  dropdown.appendChild(div);
                  spinner.classList.remove("spinning-datalist");
                }
              } else {
                idInput.setAttribute("hasError", "true");
                input.style.border = "1px solid red";
                error.innerHTML = "No results found";
                dropdown.style.display = "none";
                spinner.classList.remove("spinning-datalist");
              }
            });
        } catch (error) {
          console.log(error);
        }
      } else {
        idInput.setAttribute("hasError", "true");
        dropdown.style.display = "none";
        dropdown.innerHTML = "";
        spinner.classList.remove("spinning-datalist");
      }
    }, 600);
  });
});

function onSubmit() {
  const datalists = document.querySelectorAll(".dropdown-datalist");
  for (let i = 0; i < datalists.length; i++) {
    const idInput = datalists[i].querySelector("#idfield");
    if (idInput.getAttribute("hasError") == "true") {
      return false;
    }
  }
  return true;
}
