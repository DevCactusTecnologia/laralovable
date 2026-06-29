const validator = (mask) => {
    return ({ 
        mask: [{ 'mask': mask }], 
        greedy: false, 
        definitions: { '#': { validator: '[0-9]', cardinality: 1 }} 
    });
}

$('#mobile').inputmask(validator('(##) # ####-####'));
$('#cns').inputmask(validator('### #### #### ####'));
$('#cpf').inputmask(validator('###.###.###-##'));

function triggerClick() {
    const newProfilePhoto = document.querySelector('#new_profile_photo');
    const profilePhoto = document.querySelector('#profile_photo');

    if (newProfilePhoto) { newProfilePhoto.click(); }
    if (profilePhoto) { profilePhoto.click(); }
}

function displayProfile(event) {
    if (event.files[0]) {
        const reader = new FileReader();
        reader.onload = function(event) {
            let size = event.total;
            let counter = 0;
            const unit = ['B', 'KB', 'MB', 'GB'];

            while (size > 900) {
                size /= 1024;
                counter++;
            }

            const exactSize = Math.round(size*100)/100;
            const typeSize = unit[counter];

            if (typeSize === 'MB' || typeSize === 'GB') {
                document.getElementById('profile_display').value = '';
                return alert(`Imagem de perfil muito grande: ${exactSize} ${typeSize}\nA imagem de assinatura a ser carregada não pode ser superior a 30 KB`);
            }

            if (size > 100) {
                document.getElementById('profile_display').value = '';
                return alert(`Imagem de perfil grande: ${exactSize} ${typeSize}\nA imagem de assinatura a ser carregada não pode ser superior a 30 KB`);
            }

            const profileDisplay = document.querySelector('#profile_display');
            profileDisplay.setAttribute('src', event.target.result);
        }

        reader.readAsDataURL(event.files[0]);
    }
}

function triggerClickSignature() {
    const newSignature = document.querySelector('#new_signature');
    const signature = document.querySelector('#signature');

    if (newSignature) { newSignature.click(); }
    if (signature) { signature.click(); }
}

function displayProfileSignature(event) {
    if (event.files[0]) {
        const reader = new FileReader();
        reader.onload = function(event) {
            let size = event.total;
            let counter = 0;
            const unit = ['B', 'KB', 'MB', 'GB'];

            while (size > 900) {
                size /= 1024;
                counter++;
            }

            const exactSize = Math.round(size*100)/100;
            const typeSize = unit[counter];

            if (typeSize === 'MB' || typeSize === 'GB') {
                document.getElementById('signature_display').value = '';
                return alert(`Imagem de assinatura muito grande: ${exactSize} ${typeSize}\nA imagem de assinatura a ser carregada não pode ser superior a 20 KB`);
            }

            if (size > 20) {
                document.getElementById('signature_display').value = '';
                return alert(`Imagem de assinatura grande: ${exactSize} ${typeSize}\nA imagem de assinatura a ser carregada não pode ser superior a 20 KB`);
            }

            const signatureDisplay = document.querySelector('#signature_display');
            signatureDisplay.setAttribute('src', event.target.result);
        }

        reader.readAsDataURL(event.files[0]);
    }
}

function loader(button) {
    setTimeout(() => {
        button.disabled = true;
        button.innerHTML = (
            `<span class="spinner-border spinner-border-sm" 
                role="status" aria-hidden="true">
            </span> Aguarde...`
        );
    }, 10);

    setTimeout(() => {
        button.disabled = false;
        button.innerHTML = 'Adicionar novo analista';
    }, 7000);
}
