let audio = new Audio();
audio.volume = 0.3;
let tiempo;
let audio_id = -1;
$(document).ready(function () {

  //Iniciar la reproducción de una canción
  $('.fa-play-circle').on('click', function () {
    let cancion = $(this).siblings('input:hidden');
    console.log(cancion.attr('id'));
    if (audio_id == -1) {
      audio.src = cancion.val();
      audio_id = cancion.attr('id');
      audio.play();
      $(this).addClass('hide');
      $(this).siblings('.fa-pause-circle').removeClass('hide')
    }
    else {
      if (audio_id == cancion.attr('id')) {
        audio.currentTime = tiempo;
        tiempo = 0;
        audio.play();
        $(this).addClass('hide');
        $(this).siblings('.fa-pause-circle').removeClass('hide')
      }
      else {
        console.log("distintos");
        audio_id = cancion.attr('id');
        tiempo = 0;
        audio.currentTime = 0.0;
        audio.src = cancion.val();
        audio.play();
        $('.fa-pause-circle').addClass('hide');
        $('.fa-play-circle').removeClass('hide');
        $(this).addClass('hide');
        $(this).siblings('.fa-pause-circle').removeClass('hide')
      }
    }


  });

  //Pausa la reproducción de una canción
  $('.fa-pause-circle').on('click', function () {
    let cancion = $(this).siblings('input:hidden');
    audio_id = cancion.attr('id');
    tiempo = audio.currentTime;
    audio.pause();
    $(this).addClass('hide');
    $(this).siblings('.fa-play-circle').removeClass('hide')
    console.log("Tiempo: " + tiempo + " y el audio_id es " + audio_id);
  });

  //Parar la reproducción de una canción
  $('.fa-stop-circle').on('click', function () {
    audio.pause();
    audio.src = "";
    tiempo = 0;
  });

  //Volver todo al inicio en el momento que se acabe una canción
  $(audio).on('ended', function () {
    audio_id = -1;
    audio.currentTime = 0.0;
    tiempo = 0;
    $('.fa-pause-circle').addClass('hide');
    $('.fa-play-circle').removeClass('hide');
  });

});

//onclick="play(this);"
// function play(play) {
//   let cancion = $(play).siblings('input:hidden');
//   $(play).removeClass('fa-play-circle').addClass('fa-pause-circle');
//   $(play).attr('onclick', 'pause(this)');
//   if (audio_id == -1) {
//     audio.src = cancion.val();
//   }
//   else {
//     if (audio_id == cancion.attr('id')) {
//       audio.currentTime = tiempo;
//     }
//     else {
//       nueva_cancion = $("#" + cancion.attr('id')).siblings('input:hidden');
//       console.log(cancion.attr('id'));
//       audio.src = nueva_cancion.val();
//     }
//   }

//   audio.play();
// }

// function pause(pause) {
//   let cancion = $(pause).siblings('input:hidden');
//   $(pause).removeClass('fa-pause-circle').addClass('fa-play-circle');
//   $(pause).attr('onclick', 'play(this)');
//   audio_id = cancion.attr('id');
//   console.log(audio_id);
//   tiempo = audio.currentTime;
//   console.log("Tiempo: " + tiempo);
//   audio.pause();
// }