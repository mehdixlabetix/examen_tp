$td=document.querySelectorAll("td")
    $td.forEach((e) => e.addEventListener("click",
        () => {e.classList.toggle("highlight");})
);
