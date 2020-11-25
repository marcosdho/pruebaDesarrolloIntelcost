let filterCity='na',filterType='na',clickBienes='na';

$(function(){
    init()
})

const init = async () => {
    await getAll()
    await getCities();
    await getTypes();

    document.getElementById('selectCiudad').addEventListener('change',({target})=>{
    filterCity = target.value;
    })
    document.getElementById('selectTipo').addEventListener('change',({target})=>{
    filterType = target.value;
    })
    document.getElementById('clickBienes').addEventListener('click',({target})=>{
        $("#listaB").html("")
        fetch('./Clases/Index.php?bienes=true')
        .then((resp)=>resp.json())
        .then((d)=>{
            console.log(d)
            $(".countB").html(Object.keys(d).length)
        for(var i in d){
            $("#listaB").append(template(d[i],false))
        }
        })
    })
    $("#submitButton").on('click',(e)=>{
    e.preventDefault();
    const data = {
        filter:true,
        city:filterCity,
        type:filterType
    }

    
    fetch(`./Clases/Index.php?filter=${data.filter}&city=${data.city}&type=${data.type}`)
    .then((resp)=>resp.json())
    .then((list)=>{
        $("#lista").html("");
        var count = 0
        for(var i in list){
            $(".count").html((count ++) + (1))
        $("#lista").append(template(list[i]))
        }
    })
    })
}

const getAll = () =>{
    fetch('./Clases/Index.php')
    .then((resp)=>resp.json())
    .then((d)=>{
        var count = 0
    for(var i in d){
        $(".count").html((count ++) + (1))
        $("#lista").append(template(d[i]))
    }
    })
}

const getCities = () => {
    let ini = '<option value="na" selected>Elige una ciudad</option>';
    fetch('./Clases/Index.php?cities=true')
    .then((resp)=>resp.json())
    .then((d)=>{
    for(var i in d){
        ini += `<option value='${d[i]}'>${d[i]}</option>`
    }
    $("#selectCiudad").html(ini);
    })
}

const getTypes = () => {
    let ini = '<option value="na">Elige un tipo</option>';
    fetch('./Clases/Index.php?types=true')
    .then((resp)=>resp.json())
    .then((d)=>{
    for(var i in d){
        ini += `<option value='${d[i]}'>${d[i]}</option>`
    }
    $("#selectTipo").html(ini);
    })
}

const saveData = (target) => {
    let id = target.split('-')[1]
    fetch('./Clases/Index.php?save=true&id='+id)
    .then((resp)=>resp.json())
    .then((d)=>{
        console.log(d)
    })
}

const template = (data,btn=true) => {  
    const {id,Direccion,Ciudad,Telefono,Codigo_Postal,Tipo,Precio} = data;
    const boton = (btn) ? `<button id="boton-${id}" onClick="saveData(this.id)" data-id="${id}">Guardar</button>` : ''
    return `<div id=${id}>
            <div class="tituloContenido card" style="padding: 10px; width: 700px;">
                <div style="display: flex; flex-direction: row;">
                <img src="./img/home.jpg" width="350px" height="250">
                <div style="display: flex; flex-direction: column;">
                    <b>Dirección:</b> ${Direccion}
                    <b>Ciudad:</b> ${Ciudad}
                    <b>Teléfono:</b> ${Telefono}
                    <b>Código </b>Postal: ${Codigo_Postal}
                    <b>Tipo:</b> ${Tipo}
                    <b>Precio:</b> ${Precio}
                    ${boton}

                </div>
                </div>
            </div>
            </div>`;
}
