const btnsZona = document.getElementsByName("btnsZona");
const divZona = document.getElementById("divZona");
const divEspec = document.getElementById("divEspec");
const divParc = document.getElementById("divParc");
const divEspecPar = document.getElementById("divEspecPar");
const title = document.getElementById("title");
const btnVoltar = document.getElementById("btnVoltar");
const btnsEspec = document.getElementsByName("btnsEspec");

let opcEspec;
let btnEspecOpc;
let opcZona;

var parceiroJson;

let zonas = ["Zona Norte", "Zona Sul", "Centro", "Zona Leste", "Zona Oeste"];

var xmlhttp = new XMLHttpRequest();
xmlhttp.onreadystatechange = function() {
  if (this.readyState == 4 && this.status == 200) {
    parceiroJson = JSON.parse(this.responseText);
  }
};
xmlhttp.open("GET", "parceiros.json", true);
xmlhttp.send(); 

for (let item of btnsZona) {
    item.addEventListener("click", () => {
        opcZona = item.innerText;
        mostrarEspecs();
    });
}
//Fazer Funcionar

function mostrarEspecsParc(){
    for (let i = 0; i < parceiroJson.especialidades.length ; i++) 
    {
        const newButton = document.createElement('input');
        const newButton2 = document.createElement('label');
        const newDiv = document.createElement('div');
        newDiv.className = "form-check form-check-inline mb-3"
        newButton.className = "form-check-input";
        newButton.type = "checkbox";
        newButton.value = parceiroJson.especialidades[i];
        newButton.id = "chk" + parceiroJson.especialidades.indexOf(parceiroJson.especialidades[i]);
        newButton2.innerText = parceiroJson.especialidades[i];
        newButton2.htmlFor = "chk" + parceiroJson.especialidades.indexOf(parceiroJson.especialidades[i]);
        newButton.name = "chkEspecsParceiros";
    
        divEspecPar.append(newDiv);
        newDiv.append(newButton);
        newDiv.append(newButton2); 
    }
}

function mostrarEspecs() {
    divZona.className = "d-grid gap-2 pt-3 d-none";


    for (let i = 0; i < parceiroJson.especialidades.length; i++) {
        title.innerHTML = "<h1>Selecione a Especialidade:</h1>";
        const newButton = document.createElement('button');
        newButton.name = "btnsEspec";
        newButton.className = "btn btn-card-contra";
        newButton.type = "button";
        newButton.innerText = parceiroJson.especialidades[i];
        newButton.id = "btn" + parceiroJson.especialidades.indexOf(parceiroJson.especialidades[i]);
        newButton.addEventListener("click", ()=>{
            opcEspec = newButton.innerText;
            mostrarParc();
        });
        divEspec.append(newButton);    
    }
}


function mostrarParc() {
    console.log("Ok");

    title.innerHTML = "<h1>Selecione o Parceiro:</h1>";
    divEspec.className = "d-none";

    for (let i = 0; i < parceiroJson.parceiros.length; i++) {

        for(let it = 0; it < parceiroJson.especialidades.length; it++){
            if(parceiroJson.parceiros[i].especialidade[it] == opcEspec && parceiroJson.parceiros[i].zona == opcZona){
                
                    const newButton = document.createElement('button');
                    newButton.name = "btnsParc";
                    newButton.className = "btn btn-card-contra";
                    newButton.type = "button";
                    newButton.innerHTML = parceiroJson.parceiros[i].nome + "<br>" + parceiroJson.parceiros[i].endereco +'<br>' +parceiroJson.parceiros[i].telefone;
        
                    divParc.append(newButton);
                
            }   
        }
    }
}

function carrega(){
    for (let i = 0; i < parceiroJson.especialidades.length ; i++) 
{
    const newButton = document.createElement('input');
    newButton.name = "btnsEspec";
    newButton.className = "form-check-input";
    newButton.type = "check";
    newButton.value = parceiroJson.especialidades[i];
    newButton.id = "btn" + parceiroJson.especialidades.indexOf(parceiroJson.especialidades[i]);

    divEspec.append(newButton);    
}
}


btnVoltar.addEventListener("click", function () {
    divZona.className = "d-grid gap-2 pt-3 d-block";
    divEspec.innerHTML = "";
    divEspec.className = "d-grid gap-2 pt-3 d-block";
    divParc.innerHTML = "";
    title.innerHTML = "<h1>Selecione a Zona:</h1>";
    opcEspec = "";
});






