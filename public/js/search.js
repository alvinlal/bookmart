class Search {
  constructor() {
    this.searchInput = document.querySelector("input[name='search']");
    this.searchBarDiv = document.querySelector(".search-bar");
    this.searchResultsDiv = document.createElement("div");
    this.searchResultsDiv.classList.add("dropdown-search");
    this.spinner = document.createElement("div");
    this.searchBarDiv.appendChild(this.spinner);
    this.searchInput.addEventListener("keyup", this.handleSearch.bind(this));
    this.errorDiv = document.createElement("div");
    this.errorDiv.classList.add("search-bar-error");
    this.errorDiv.innerHTML = "No Results!";
  }

  spinUp() {
    this.spinner.classList.add("spinning-datalist");
  }

  spinDown() {
    this.spinner.classList.remove("spinning-datalist");
  }

  showError() {
    this.searchResultsDiv.innerHTML = "";
    this.searchResultsDiv.appendChild(this.errorDiv);
    this.searchBarDiv.appendChild(this.searchResultsDiv);
  }

  showResults(results) {
    this.searchResultsDiv.innerHTML = "";
    results.forEach(result => {
      const searchResultItemDiv = document.createElement("div");
      searchResultItemDiv.classList.add("dropdown-search-item");
      const a = document.createElement("a");
      if (result.type == "item") {
        a.href = `/bookmart/item.php?id=${result.id}`;
        a.innerHTML = `${result.result} in <b>Books</b>`;
      } else if (result.type == "author") {
        a.href = `/bookmart/viewByAuthor.php?authorid=${result.id}`;
        a.innerHTML = `${result.result} in <b>Authors</b>`;
      }
      searchResultItemDiv.appendChild(a);
      this.searchResultsDiv.appendChild(searchResultItemDiv);
    });
    this.searchBarDiv.appendChild(this.searchResultsDiv);
  }

  handleSearch = e => {
    var query = e.target.value;
    if (query) {
      query = e.target.value.toLowerCase().trim();
      this.spinUp();
      clearTimeout(this.typingTimer);
      this.typingTimer = setTimeout(() => {
        try {
          var url;
          if (query.match(/^[0-9]{10,13}$/)) {
            url = `/bookmart/search.php?q=${query}&searching=true&filter=isbn`;
          } else {
            url = `/bookmart/search.php?q=${query}&searching=true`;
          }
          fetch(url)
            .then(res => res.json())
            .then(data => {
              if (data.length) {
                this.showResults(data);
                this.spinDown();
              } else {
                this.spinDown();
                this.showError();
              }
            });
        } catch (err) {
          console.log(err);
        }
      }, 500);
    } else {
      clearTimeout(this.typingTimer);
      this.spinDown();
      this.searchResultsDiv.remove();
    }
  };
}

const search = new Search();
