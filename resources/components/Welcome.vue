<template>
  <div class="center">
        User Name
        <input type="text"> 
        <br />
        Password
        <input type="password">
        <br>
        <input type="submit">
  </div>
</template>
<script>
export default {
  name: 'Welcome',
};
</script>
<style scoped>
#app{
    height: 100vh;
}
.center {
    position: relative;
    width: 300px;
    height: 200px;
    top: 50%;
    left: 50%;
    margin-left: -150px;
    margin-top: -100px;
  }
</style>