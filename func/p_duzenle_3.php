<?php
$msj_opt = array(
    "Hiçkimse",
    "Sadece takip ettiklerim",
    "Herkes",
);
?>

<p class="flow_header" style="margin-left: 10px; font-family: 'Kalam'; font-size: 25px;">Gizlilik Ayarları</p>

<p class="set-field-header">Mesaj alımı:</p>
<div class="set-field-cont">
    <label>Kimlerin özel mesaj gönderebileceğini seçin:</label>
    <div style="width: 100%;"><br/></div>
    <form id="msg_form" action="" method="post">
    <select name="mesaj-tercihi" id="msj-tercihi" class="select-css" style="display: inline;">
        <option value="Sec">Mesaj tercihi seçin:</option>
        <option value="0"><?php echo $msj_opt[0]; ?></option>
        <option value="1"><?php echo $msj_opt[1]; ?></option>
        <option value="2"><?php echo $msj_opt[2]; ?></option>
    </select>
    <button class="ara-btn" id="msg-onay-btn" style="display: inline; background-color: #5CC1FF; padding: 0 10px; margin-left: 10px;" type="submit" name="tercih_gonder" disabled>Değiştir</button>
    </form>
    <div style="width: 100%;"></div>
    <p style="margin: 5px 0 0 5px; font-size: 9pt; color: #666;">(Mevcut: <b><?php echo $msj_opt[0]; ?></b>)</p>
</div>

<p class="set-field-header">Boş:</p>
<div class="set-field-cont">
    <label class="switch">
        <input type="checkbox" id="mesaj-cb">
        <span class="slider round"></span>
    </label>
    <label for="mesaj-cb" style="margin-left: 10px;">Örnek switch</label>
</div>


<script>
    document.getElementById("msj-tercihi").addEventListener("change", butonDavranisi);

    function butonDavranisi() {
        const x = document.getElementById("msj-tercihi");
        const msgval = x.value;
        const y = document.getElementById("msg-onay-btn");

        if(parseInt(msgval) >= 0 || parseInt(msgval) <= 2) {
            document.getElementById("msg-onay-btn").disabled = false;
        }
        else
        {
            document.getElementById("msg-onay-btn").disabled = true;
        }
    }
</script>