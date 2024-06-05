<a href="/home" class="absolute left-5 top-4 md:top-5 w-12 md:w-16 h-12 md:h-16">
    <img class="p-2 bg-customBlue rounded-xl" src="../../assets/images/icon/home.svg" alt="Delete">
</a>
<a class="absolute right-5 top-5 md:top-4 w-12 md:w-16 h-12 md:h-16">
    <img class="p-2 bg-customBlue rounded-xl actionButton cursor-pointer" src="../../assets/images/icon/disconnect.svg"
         data-action="disconnect" alt="disconnect">
</a>

<div class="flex justify-center items-center">
    <img src="https://api.qrserver.com/v1/create-qr-code/?data=https://learning-web.alwaysdata.net/sessionCode?code=<?= $_GET['code'] ?? "" ?>&size=500x500" alt="qr code"/>
</div>