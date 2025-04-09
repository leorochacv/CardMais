const cepF = document.getElementById("cepPacFam");
const ruaF = document.getElementById("ruaPacFam");
const bairroF = document.getElementById("bairroPacFam");
const cidadeF = document.getElementById("cidadePacFam");
const estadoF = document.getElementById("estadoPacFam");
const messageF = document.getElementById("messageFam");

cepF.addEventListener("focusout", async () => {
    const apenasNum = /^[0-9]+$/;

    try {
        if(!apenasNum.test(cepF.value)){
            throw{cep_erro: 'Cep Inválido'};
        }
        const response = await fetch(`https://viacep.com.br/ws/${cepF.value}/json/`)

        if(!response.ok){
            throw await response.json();
        }

        const responseCep = await response.json();

        ruaF.value = responseCep.logradouro;
        bairroF.value = responseCep.bairro;
        cidadeF.value = responseCep.localidade;
        estadoF.value = responseCep.uf;


    } catch (error) {
        if(error?.cep_erro){
            messageF.textContent = error.cep_erro;
            setTimeout(()=>{
                message.textContent = "";
            }, 5000)
        }
        
    } 
})