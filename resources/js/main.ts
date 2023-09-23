window.onload = () => {
    //? Carousel for review in main page edit
    const caroul = document.querySelector(".caroul");
    if(caroul) {
        const nextBtn = document.querySelector(".caroul-button.next");
        const prevbtn = document.querySelector(".caroul-button.prev");
        nextBtn?.addEventListener("click", () => {
            caroul?.scrollBy({
                left: caroul.clientWidth,
                behavior: "smooth",
            });
        });
    
        prevbtn?.addEventListener("click", () => {
            caroul?.scrollBy({
                left: -caroul.clientWidth,
                behavior: "smooth",
            });
        });
    }
    

    //? Popup Countdown Timer in website
    const countdown = document.querySelector(".timer-container");
    if(countdown) {
        const date = countdown?.getAttribute("data-date");
        const time = countdown?.getAttribute("data-time");
        const targetTime = `${date}T${time}`;    
    
        const updateCountdown = (targetDate: string) => {
            const targetTime = new Date(targetDate).getTime();
    
            const calculateRemainingTime = () => {
                const now = new Date().getTime();
                const timeRemaining = targetTime - now;
    
                if(timeRemaining < 0) {
                    // TODO make the timer-container text 'Offer Ended'
                    countdown!.querySelector('.offer-end')?.classList.remove('hidden');
                    return
                }
    
                const hours = Math.min(Math.floor(timeRemaining / (1000 * 60 * 60)),99);    
                const minute = Math.floor(timeRemaining % (1000 * 60 * 60) / (1000 * 60));
                const second = Math.floor(timeRemaining % (1000 * 60) / (1000));
                
                countdown!.querySelector('.hour')!.innerHTML = hours < 10 ? '0' + hours : `${hours}`;            
                countdown!.querySelector('.minute')!.innerHTML = minute < 10 ? '0' + minute : `${minute}`;            
                countdown!.querySelector('.second')!.innerHTML = second < 10 ? '0' + second : `${second}`;            
            }
            calculateRemainingTime();
            setInterval(calculateRemainingTime, 1000)
        };    
        updateCountdown(targetTime);
    }    
};
