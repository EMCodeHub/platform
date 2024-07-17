
function generateUniqueId() {


    const characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
    const numbers = '0123456789';
  
    let randomString = '';
    
    // Generar letras aleatorias
    for (let i = 0; i < 5; i++) {
      randomString += characters.charAt(Math.floor(Math.random() * characters.length));
    }
    
    // Agregar un guion y un número aleatorio
    randomString += '-';
    for (let i = 0; i < 3; i++) {
      randomString += numbers.charAt(Math.floor(Math.random() * numbers.length));
    }
    
    // Agregar otro guion y más letras aleatorias
    randomString += '-';
    for (let i = 0; i < 8; i++) {
      randomString += characters.charAt(Math.floor(Math.random() * characters.length));
    }
    
    // Agregar otro guion y más letras y números aleatorios
    randomString += '-';
    for (let i = 0; i < 12; i++) {
      randomString += characters.charAt(Math.floor(Math.random() * characters.length));
    }
    
    // Retornar el identificador único generado
    return randomString;


  }
  