<template>
  <div class="admin-tags">
    <el-table
      :data="tags"
      style="width: 100%"
    >
      <el-table-column
        prop="id"
        label="ID"
        width="40"
      />
      <el-table-column
        prop="name"
        label="Name"
      />
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
      label-width="100px"
      :label-position="'top'"
    >
      <el-form-item
        label="Name"
        prop="name"
      >
        <el-input
          v-model="form.name"
          placeholder="Name"
        />
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

import { useTagStore } from '@/store/tagStore';

export default {
  name: 'AdminTags',
  setup() {
    const formEl = ref(null);
    const tagStore = useTagStore();
    const tags = computed(() => tagStore.tags);
    const form = ref({});
    onMounted(() => {
      tagStore.getTags();
    });
    const handleDelete = async (row) => {
      tagStore.deleteTag(row.id);
    };
    const handleSubmit = async () => {
      await formEl.value.validate();
      await tagStore.createTag(form.value);
      form.value = {};
    };
    const uniqueValidator = (rule, value, callback) => {
      const isUnique = tags.value.every((tag) => tag.name !== value);
      if (isUnique) {
        callback();
      } else {
        callback(new Error('Tag name must be unique'));
      }
    };
    const rules = ref({
      name: [
        { required: true, message: 'Please input name', trigger: 'blur' },
        { min: 3, message: 'Length should be 3 at least', trigger: 'blur' },
        {
          validator: uniqueValidator,
          trigger: 'blur', 
        },
      ],
    });
    return {
      formEl,
      rules,
      form,
      handleSubmit,
      handleDelete,
      tags,
    };
  },
};
</script>

<style lang="scss" scoped>
.admin-tags {
  display: flex;
  flex-direction: column;
  gap: 2rem;
}
</style>