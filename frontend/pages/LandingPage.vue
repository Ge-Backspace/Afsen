<template>
  <div class="home">
    <HeaderAfsen />
    <HeroAfsen />
     <MidAfsen /> 
    <!-- <PartnerAfsen /> -->
    <FooterAfsen /> 
  </div>
</template>

<script>
// @ is an alias to /src 
// import HelloWorld from '@/components/HelloWorld.vue'
import HeaderAfsen from "@/components/LandingPage/HeaderAfsen.vue";
import HeroAfsen from "@/components/LandingPage/HeroAfsen.vue";
import MidAfsen from "@/components/LandingPage/MidAfsen.vue";
// import InstaAfsen from "@/components/LandingPage/InstaAfsen.vue";
// import PartnerAfsen from "@/components/LandingPage/PartnerAfsen.vue";
import FooterAfsen from "@/components/LandingPage/FooterAfsen.vue";


export default {
  name: "LandingPage",
  components: {
    HeaderAfsen,
    HeroAfsen,
    MidAfsen,
    // PartnerAfsen,
    FooterAfsen,
  },
};
</script>