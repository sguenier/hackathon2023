

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
  </div>
</template>

<script>
import {
  computed,
  onMounted,
} from 'vue';

import { useTagStore } from '@/store/tagStore';

export default {
  name: 'AdminTags',
  setup() {
    const tagStore = useTagStore();
    const tags = computed(() => tagStore.tags);
    onMounted(() => {
      tagStore.getTags();
    });
    const handleDelete = async (row) => {
      tagStore.deleteTag(row.id);
    };
    return {
      handleDelete,
      tags,
    };
  },
};
</script>

<style lang="scss" scoped>
.admin-tags {
}
</style>