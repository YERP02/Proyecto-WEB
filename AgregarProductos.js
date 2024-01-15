// 'use strict'

const Nproducto = document.querySelector('section');

const producto = document.getElementsByClassName('IntProductos');
const producto1 = document.querySelector('main section div');
const producto2 = producto1.cloneNode(true);

// const div1 = document.createElement('ImgsProducto');
const div2 = document.createElement ('nuevo'); 
const producto3 = document.querySelector('section');


div2.TEXT_NODE=producto3;
producto3.appendChild(producto2);

// div1.tagName =ImgsProducto;
// div1.textContent = 'nike'; 
// const Contproducto = document.querySelector('main section div div div')

// Nproducto.appendChild(div1);

// const comida = ['Huevo', 'carne', 'Manzana', 'Leche'];

// for( let i=0 ; i< comida.length; i++){
//     const li = document.createElement('li');
//     li.textContent = comida('li');
//     producto.appendChild(li);
// }

// comida.forEach((item) =>{
//     const li = document.createElement("li");
//     li.textContent = item;
//     producto.appendChild(li);
// })