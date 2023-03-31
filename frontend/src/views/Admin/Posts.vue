<template>
  <div class="admin-posts">
    <el-table
      :data="posts"
      style="width: 100%"
    >
      <el-table-column
        prop="id"
        label="ID"
        width="40"
      />
      <el-table-column
        prop="title"
        label="Title"
        width="150"
      />
      <el-table-column
        prop="content"
        label="Content"
        width="400"
      >
        <template #default="{ row }">
          <div
            v-html="row.content"
          />
        </template>
      </el-table-column>
      <el-table-column
        prop="Tag"
        label="Tags"
        width="150"
      >
        <template #default="{ row }">
          <el-tag
            v-for="tag in row.Tag"
            :key="tag.id"
            :type="tag.type"
            :closable="false"
            disable-transitions
          >
            {{ tag.name }}
          </el-tag>
        </template>
      </el-table-column>
      <el-table-column
        prop="createdAt"
        label="Created At"
        width="210"
      />
      <el-table-column
        prop="image"
        label="Image"
        width="150"
      >
        <template #default="{ row }">
          <img
            v-if="row.image"
            :src="`http://localhost/uploads/posts/${row.image}`"
            :alt="row.title"
            style="width: 100px"
          >
        </template>
      </el-table-column>
      <el-table-column
        label="Actions"
        width="200"
      >
        <template #default="{ row }">
          <!-- <el-button
            type="warning"
            size="small"
            @click="handleEdit(row)"
          >
            Edit
          </el-button> -->
          <el-button
            type="danger"
            size="small"
            @click="handleDelete(row)"
          >
            Delete
          </el-button>
        </template>
      </el-table-column>
    </el-table>
    <el-form
      ref="formEl"
      :model="form"
      :rules="rules"
      :label-position="'top'"
    >
      <el-form-item
        label="Title"
        prop="title"
      >
        <el-input
          v-model="form.title"
          placeholder="Title"
        />
      </el-form-item>
      <el-form-item
        label="Content"
        prop="content"
      >
        <div class="wiziwig">
          <quill-editor
            ref="editor"
            theme="snow"
            v-model:content="form.content"
            contentType="html"
          />
        </div>
      </el-form-item>
      <el-form-item
        label="Tags"
        prop="tags"
      >
        <el-checkbox-group v-model="form.tags">
          <el-checkbox
            v-for="tag in tags"
            :key="tag.id"
            :label="tag.id"
          >
            {{ tag.name }}
          </el-checkbox>
        </el-checkbox-group>
      </el-form-item>
      <el-form-item>
        <el-button
          type="primary"
          @click="handleSubmit"
        >
          Submit
        </el-button>
      </el-form-item>
    </el-form>
  </div>
</template>

<script>
import {
  computed,
  onMounted,
  ref,
} from 'vue';

import { useBlogStore } from '@/store/blogStore';
import { useTagStore } from '@/store/tagStore';

export default {
  name: 'AdminPosts',
  setup() {
    const editor = ref(null);
    const formEl = ref(null);
    const postStore = useBlogStore();
    const tagStore = useTagStore();
    const posts = computed(() => postStore.advises);
    const tags = computed(() => tagStore.tags);
    const form = ref({});
    onMounted(() => {
      postStore.getAdvises();
      tagStore.getTags();
    });
    const handleDelete = async (row) => {
      postStore.deletePost(row.id);
    };
    const handleSubmit = async () => {
      await formEl.value.validate();
      await postStore.createPost(form.value);
      editor.value.setText('');
      form.value = {};
    };
    const rules = ref({
      title: [ { required: true, message: 'Please input name', trigger: 'blur' }, { min: 3, message: 'Length should be 3 at least', trigger: 'blur' } ],
      content: [ { required: true, message: 'Please input content', trigger: 'blur' }, { min: 3, message: 'Length should be 3 at least', trigger: 'blur' } ],
      tags: [ { required: true, message: 'Please input tags', trigger: 'blur' } ],
    });
    return {
      editor,
      tags,
      formEl,
      rules,
      form,
      handleSubmit,
      handleDelete,
      posts,
    };
  },
};
</script>

<style lang="scss" scoped>
.admin-posts {
  display: flex;
  flex-direction: column;
  gap: 2rem;
}

.wiziwig {
  width: 100%;
  height: 300px;
  margin-bottom: 50px;
}
</style>