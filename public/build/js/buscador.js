const d=document;function iniciarApp(){buscarPorFecha()}function buscarPorFecha(){d.querySelector("#fecha").addEventListener("input",n=>{const e=n.target.value;window.location="?fecha="+e})}d.addEventListener("DOMContentLoaded",(function(){iniciarApp()}));
//# sourceMappingURL=buscador.js.map
