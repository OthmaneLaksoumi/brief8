let filter = document.getElementById("filter");
// let arduino = document.querySelectorAll(".Arduino");
let afficheur = document.querySelectorAll(".Afficheur");
let robot = document.querySelectorAll(".Robot");
let diode = document.querySelectorAll(".Diode");
let batterie = document.querySelectorAll(".Batterie");
let composant = document.querySelectorAll(".Composants");

let catg = [afficheur, batterie, composant, diode, robot];

filter.addEventListener('change', function () {
    catg.forEach(function (categorie) {
        categorie.forEach(function (pro) {
            pro.style.display = 'none';
        });
    });

    if (filter.value === '0') {
        catg.forEach(function (categorie) {
            categorie.forEach(function (pro) {
                pro.style.display = 'block';
            });
        });
    }

    if (Number(filter.value) <= catg.length && Number(filter.value) > 0) {
        catg[Number(filter.value) - 1].forEach(function (pro) {
            pro.style.display = 'block';
        });
    }

    if (filter.value === '6') {
        catg.forEach(function (categorie, i) {
            categorie.forEach(function (pro) {
                let qntMin = pro.querySelector('.qntMin');
                let qntStock = pro.querySelector('.qntStc');
                if (Number(qntMin.innerHTML.match(/\d+/)[0]) >= Number(qntStock.innerHTML.match(/\d+/)[0])) {
                    pro.style.display = 'block';
                }


            });
        });
    }
});

let itemsPerPage = 5;
let itemsList = document.querySelector('.product-menu').querySelectorAll('.product-item');
const totalItems = itemsList.length;
const numberOfPages = Math.ceil(totalItems / itemsPerPage);
for (let i = 0; i < numberOfPages; i++) {
    let paginationNumber = document.createElement('li');
    paginationNumber.innerText = i + 1;
    document.querySelector('.pagination').appendChild(paginationNumber);
}

function displayItems(i, j) {

    let itemsAfficher = Array.from(itemsList);
    itemsAfficher.forEach(function (pro, index) {
        if ((index >= i && index <= j)) {
            pro.style.display = 'block';
        } else {
            pro.style.display = 'none';

        }
    })
    // console.log(itemsAfficher);
}
displayItems(0, itemsPerPage - 1);
let paginationBtn = Array.from(document.querySelector('.pagination').querySelectorAll('li'));

paginationBtn.forEach(function (btn) {
    btn.addEventListener('click', function () {
        displayItems((Number(btn.innerText) - 1) * itemsPerPage, (Number(btn.innerText) - 1) * itemsPerPage + itemsPerPage - 1);
    })
})

itemsList.forEach(function (item) {
    item.addEventListener('click', function () {
        console.log(item.innerText);
    })
})


