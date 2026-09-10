<div class="modal" id="modal" onclick="this.classList.remove('active')">
    <img id="modalImg" src="">
</div>
<script>
function showImg(src){document.getElementById('modalImg').src=src;document.getElementById('modal').classList.add('active')}
</script>