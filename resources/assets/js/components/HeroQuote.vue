<template>
  <div class="hero-quote">
    <div class="hero-quote__wrapper">
      <div class="hero-quote__lig hero-quote__lig--left">&ldquo;</div>
      <div class="hero-quote__content"><slot></slot></div>
      <div class="hero-quote__lig hero-quote__lig--right">&rdquo;</div>
    </div>
    <div class="hero-quote__author">&mdash; {{ author }}</div>
  </div>
</template>

<script>
  export default {
    name: 'hero-quote',
    props: [
      'author'
    ],
  };
</script>

<style lang="stylus" scoped>
  .hero-quote {
    font-family: 'Bellefair', 'Roboto Slab', serif;
    color: white;
    padding: 24px 80px;

    .hero-quote__wrapper {
      display: flex;
      text-align: center;
      align-items: center;
      justify-content center;
    }

    .hero-quote__content {
      font-size: 32px;
      max-width: 70%;
    }

    .hero-quote__lig {
      font-size: 112px;
      height: 112px;
    }

    .hero-quote__author {
      font-size: 22px;
      text-align right;
    }
  }
</style>
