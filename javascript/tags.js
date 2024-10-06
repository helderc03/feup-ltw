const selectEl = document.getElementById("tags");
const tagsContainer = document.querySelector(".selected-tags-container");
const searchInput = document.getElementById("searchInput");

function displaySelectedTags() {
  const selectedOptions = Array.from(selectEl.selectedOptions);
  tagsContainer.innerHTML = "";
  selectedOptions.forEach(function (option) {
    const tagEl = document.createElement("div");
    tagEl.classList.add("tag");
    tagEl.textContent = option.textContent;
    tagsContainer.appendChild(tagEl);
  });
}

function handleSearch(event) {
  const searchQuery = event.target.value.toLowerCase();
  const options = Array.from(selectEl.options);

  options.forEach(function (option) {
    const tagText = option.textContent.toLowerCase();
    const tagOptionEl = option;
  
    if (tagText.includes(searchQuery) || searchQuery === "" || tagText.startsWith(searchQuery)) {
      tagOptionEl.style.display = "block";
    } else {
      tagOptionEl.style.display = "none";
    }
  });

}

document.addEventListener("DOMContentLoaded", function() {
  displaySelectedTags();
});

selectEl.addEventListener("click", function (event) {
  if (event.target.tagName === "OPTION") {
    displaySelectedTags();
  }
});

searchInput.addEventListener("input", handleSearch);
