// register.js - Validación del lado del cliente para registro

document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('registerForm');
    
    if (form) {
        form.addEventListener('submit', function(e) {
            const email = document.getElementById('email').value.trim();
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('confirm_password').value;
            
            // Validar email universitario
            if (!isUniversityEmail(email)) {
                e.preventDefault();
                alert('You must use a university email address to register. Personal emails like Gmail, Outlook, Yahoo, etc. are not allowed.');
                return false;
            }
            
            // Validar coincidencia de contraseñas
            if (password !== confirmPassword) {
                e.preventDefault();
                alert('Passwords do not match. Please try again.');
                return false;
            }
            
            // Validar longitud de contraseña
            if (password.length < 6) {
                e.preventDefault();
                alert('Password must be at least 6 characters long.');
                return false;
            }
        });
        
        // Validación en tiempo real del email
        const emailInput = document.getElementById('email');
        emailInput.addEventListener('blur', function() {
            const email = this.value.trim();
            if (email && !isUniversityEmail(email)) {
                this.style.borderColor = '#dd3c10';
                showEmailError();
            } else {
                this.style.borderColor = '#ccc';
                hideEmailError();
            }
        });
    }
});

function isUniversityEmail(email) {
    // Lista de dominios universitarios permitidos
    const universityDomains = [
        'uvg.edu.gt',
        'galileo.edu',
        'usac.edu.gt',
        'url.edu.gt',
        'ufm.edu',
        'umg.edu.gt',
        'unis.edu.gt',
        'marianogalvez.edu.gt',
        // Dominios educativos internacionales comunes
        'edu',
        'ac.uk',
        'edu.mx',
        'edu.co'
    ];
    
    // Dominios personales NO permitidos
    const personalDomains = [
        'gmail.com',
        'yahoo.com',
        'outlook.com',
        'hotmail.com',
        'live.com',
        'icloud.com',
        'aol.com',
        'protonmail.com',
        'mail.com'
    ];
    
    const emailParts = email.split('@');
    if (emailParts.length !== 2) {
        return false;
    }
    
    const domain = emailParts[1].toLowerCase();
    
    // Rechazar dominios personales
    if (personalDomains.includes(domain)) {
        return false;
    }
    
    // Verificar si es un dominio universitario específico
    if (universityDomains.includes(domain)) {
        return true;
    }
    
    // Verificar si termina en .edu o .edu.[país]
    if (domain.endsWith('.edu') || domain.match(/\.edu\.[a-z]{2}$/)) {
        return true;
    }
    
    return false;
}

function showEmailError() {
    let errorDiv = document.getElementById('email-error');
    if (!errorDiv) {
        errorDiv = document.createElement('div');
        errorDiv.id = 'email-error';
        errorDiv.className = 'error-message';
        errorDiv.style.marginTop = '5px';
        errorDiv.textContent = 'Please use a university email address. Personal emails are not allowed.';
        
        const emailGroup = document.getElementById('email').closest('.form-group');
        emailGroup.appendChild(errorDiv);
    }
}

function hideEmailError() {
    const errorDiv = document.getElementById('email-error');
    if (errorDiv) {
        errorDiv.remove();
    }
}