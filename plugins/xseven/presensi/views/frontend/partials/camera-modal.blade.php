<div id="cameraModal">
    <div class="cam-box">
        <h3 id="camTitle">Ambil Foto</h3>
        <video id="video" autoplay playsinline></video>
        <canvas id="canvas"></canvas>
        <img id="preview" style="display:none">
        <div class="cam-btns" id="camBtns">
            <button class="capture" id="btnCapture" onclick="capture()">Ambil Foto</button>
            <button class="confirm" id="btnConfirm" style="display:none" onclick="confirmPhoto()">Konfirmasi</button>
            <button class="retake" id="btnRetake" style="display:none" onclick="retake()">Ulang</button>
            <button class="cancel" onclick="closeCamera()">Batal</button>
        </div>
        <p id="camError" style="color:#991b1b;font-size:.85rem;margin-top:8px;display:none"></p>
    </div>
</div>

<script>
let currentType='';let stream=null;let photoData='';
function updateClock(){const n=new Date();document.getElementById('clock').textContent=n.toLocaleTimeString('id-ID',{hour:'2-digit',minute:'2-digit',second:'2-digit'}).replace(/\./g,':')+' WIB'}
setInterval(updateClock,1000);updateClock();

async function openCamera(type){
    currentType=type;
    document.getElementById('camTitle').textContent=type==='masuk'?'Presensi Masuk':'Presensi Pulang';
    document.getElementById('cameraModal').classList.add('active');
    document.getElementById('video').style.display='block';
    document.getElementById('preview').style.display='none';
    document.getElementById('btnCapture').style.display='';
    document.getElementById('btnConfirm').style.display='none';
    document.getElementById('btnRetake').style.display='none';
    document.getElementById('camError').style.display='none';
    try{
        stream=await navigator.mediaDevices.getUserMedia({video:{facingMode:'user'}});
        document.getElementById('video').srcObject=stream;
    }catch(e){
        document.getElementById('camError').textContent='Akses kamera diperlukan untuk melakukan presensi.';
        document.getElementById('camError').style.display='block';
        document.getElementById('btnCapture').style.display='none';
    }
}
function closeCamera(){
    if(stream){stream.getTracks().forEach(t=>t.stop());stream=null}
    document.getElementById('cameraModal').classList.remove('active');
}
function capture(){
    const v=document.getElementById('video'),c=document.getElementById('canvas');
    c.width=v.videoWidth;c.height=v.videoHeight;
    c.getContext('2d').drawImage(v,0,0);
    photoData=c.toDataURL('image/jpeg',0.8);
    document.getElementById('preview').src=photoData;
    document.getElementById('video').style.display='none';
    document.getElementById('preview').style.display='block';
    document.getElementById('btnCapture').style.display='none';
    document.getElementById('btnConfirm').style.display='';
    document.getElementById('btnRetake').style.display='';
}
function retake(){
    document.getElementById('video').style.display='block';
    document.getElementById('preview').style.display='none';
    document.getElementById('btnCapture').style.display='';
    document.getElementById('btnConfirm').style.display='none';
    document.getElementById('btnRetake').style.display='none';
    photoData='';
}
async function confirmPhoto(){
    if(!photoData)return;
    const url=currentType==='masuk'?'/presensi/checkin':'/presensi/checkout';
    const res=await fetch(url,{method:'POST',headers:{'Content-Type':'application/json','X-CSRF-TOKEN':document.querySelector('meta[name=csrf-token]')?.content||''},body:JSON.stringify({foto:photoData})});
    const data=await res.json();
    const box=document.getElementById('msgBox');
    if(data.success){box.className='msg success';box.textContent=data.message;setTimeout(()=>location.reload(),1500)}
    else{box.className='msg error';box.textContent=data.error||'Gagal'}
    closeCamera();
}
</script>
<meta name="csrf-token" content="{{ csrf_token() }}">