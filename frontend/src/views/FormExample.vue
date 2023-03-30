<template>
  <main>
    <h2>Form Example</h2>
    <el-form
      :model="form"
      label-width="120px"
    >
      <el-form-item
        class="quill"
        label="Content"
      >
        <quill-editor
          theme="snow"
          v-model:content="form.content"
          contentType="html"
        />
      </el-form-item>
      <el-form-item>
        <el-button
          type="primary"
          @click="onSubmit"
        >
          Submit
        </el-button>
      </el-form-item>
    </el-form>
  </main>
</template>

<script>
import {
  ref,
} from 'vue';

export default {
  name: 'FormExample',
  setup() {
    const form = ref({});

    const onSubmit = () => {
      console.log("submit!");
      console.log(form.value);
      console.log(form.value.content);
    };

    return {
      form,
      onSubmit,
    };
  },
};
</script>

<style lang="scss" scoped>
.quill {
  display: block;
  .el-form-item__content {
    display: block;
  }

    /* display: flex; */
    /* flex-wrap: wrap; */
    /* align-items: center; */
    /* flex: 1; */
    /* line-height: 32px; */
    /* position: relative; */
    /* font-size: var(--font-size); */
    /* min-width: 0;*/
}
</style>