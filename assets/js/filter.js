//**document.addEventListener("DOMContentLoaded", function () {
   //onsole.log("Filter script loaded");
  
 // const buttons = document.querySelectorAll(".category-btn");
 // const cards = document.querySelectorAll(".product-card");
 //
 // buttons.forEach(button => {
 //   button.addEventListener("click", () => {
  //    const selected = button.dataset.category;
  
  //    cards.forEach(card => {
   //     const match = !selected || card.dataset.category === selected;
   //     card.style.display = match ? "block" : "none";
  //    });
  //  });
 // });
//});

document.addEventListener("DOMContentLoaded", () => {
    const buttons = document.querySelectorAll("#categoryFilters button");
    const cards = document.querySelectorAll(".product-card");
  
    buttons.forEach(button => {
      button.addEventListener("click", () => {
        const selected = button.getAttribute("data-category");
  
        cards.forEach(card => {
          const match = !selected || card.dataset.category === selected;
          card.style.display = match ? "block" : "none";
        });
      });
    });
  });
  
  