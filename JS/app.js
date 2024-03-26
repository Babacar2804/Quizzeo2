barba.init({
    transitions: [
      {
        name: "fade",
        
        once({ current, next, trigger }) {
          let tl = gsap.timeline();
          tl.to(".cover span", {
              y: "-100%",
              stagger: 0.1
          });
          tl.to(".cover", {
              y: "-100%",
              opacity: 0,
          });
          tl.from(".home-image", {
              x: "-100%",
              opacity: 0,
              duration: 0.1,
          });
          tl.from(".bigcard", {
              x: "-100%",
              opacity: 0,
              duration: 0.3,
          });
          tl.from("h1 span", {
              y: 100,
              stagger: 0.1,
              opacity: 0,
          });
          return tl;
      },
      enter({ current, next, trigger }) {
          let tl = gsap.timeline();
          tl.to(".cover span", {
              y: "-100%",
              stagger: 0.1
          });
          tl.to(".cover", {
              y: "-100%",
              opacity: 0,
          });
          tl.from(".home-image", {
              x: "-100%",
              opacity: 0,
              duration: 0.2, 
          });
          tl.from("h1 span", {
              y: 100,
              stagger: 0.1,
              opacity: 0,
          });
          tl.from(".bigcard", {
              x: "-100%", 
              opacity: 0,
              duration: 0.2,
          });
          return tl;
      
        },
      },
    ],
  });
  