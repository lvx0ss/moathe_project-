function getAudio() {
    const surahName = document.getElementById('surahName').value;
    const audioPlayer = document.getElementById('audioPlayer');

    // إنشاء كائن XMLHttpRequest
    const xhr = new XMLHttpRequest();

    // تحديد نوع الطلب ومسار API
    xhr.open('GET', `https://api.quran.com/api/v4/chapter_recitations/1/${surahName}`, true);

    // تحديد ما يجب فعله عند استلام الاستجابة
    xhr.onload = function() {
        if (xhr.status === 200) {
            const response = JSON.parse(xhr.responseText);
            const audioUrl = response.audio_file.audio_url;

            // تعيين رابط المقطع الصوتي لمشغل الصوت
            audioPlayer.src = audioUrl;
            audioPlayer.play();
        } else {
            alert('لم يتم العثور على السورة. يرجى التحقق من الاسم وإعادة المحاولة.');
        }
    };

    // إرسال الطلب
    xhr.send();
}

