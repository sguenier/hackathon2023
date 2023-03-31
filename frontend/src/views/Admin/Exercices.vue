<template>
  <div class="admin-exercies">
    <el-table
      :data="exercices"
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
        width="150"
      />
      <el-table-column
        prop="duration"
        label="Duration"
        width="100"
      />
      <el-table-column
        prop="equipment"
        label="Équipment"
        width="400"
      />
      <el-table-column
        prop="description"
        label="Description"
        width="400"
      >
        <template #default="{ row }">
          <div
            v-html="row.description"
          />
        </template>
      </el-table-column>
      <el-table-column
        prop="urlyoutube"
        label="Youtube URL"
        width="210"
      >
        <template #default="{ row }">
          <a
            :href="`https://www.youtube.com/watch?v=${row.urlyoutube}`"
            target="_blank"
          >
            {{ `https://www.youtube.com/watch?v=${row.urlyoutube}` }}
          </a>
        </template>
      </el-table-column>
      <el-table-column
        prop="cover"
        label="Image"
        width="150"
      >
        <template #default="{ row }">
          <img
            v-if="row.cover"
            :src="`http://localhost/uploads/exercices/${row.cover}`"
            :alt="row.name"
            style="width: 100px"
          >
        </template>
      </el-table-column>
      <el-table-column
        porp="tags"
        label="Tags"
        width="150"
      >
        <template #default="{ row }">
          <el-tag
            v-for="tag in row.tags"
            :key="tag.id"
            :type="tag.type"
            :closable="false"
            disable-transitions
          >
            {{ tag.name }}
          </el-tag>
        </template>
      </el-table-column>
      <!-- <el-table-column
        label="Actions"
        width="200"
      >
        <template #default="{ row }">
          <el-button
            type="warning"
            size="small"
            @click="handleEdit(row)"
          >
            Edit
          </el-button>
          <el-button
            type="danger"
            size="small"
            @click="handleDelete(row)"
          >
            Delete
          </el-button>
        </template>
      </el-table-column> -->
    </el-table>
    <el-form
      ref="formEl"
      :model="form"
      :rules="rules"
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
      <el-form-item
        label="Duration"
        prop="duration"
      >
        <el-input
          type="number"
          v-model="form.duration"
          placeholder="Duration"
        />
      </el-form-item>
      <el-form-item
        label="Equipment"
        prop="equipment"
      >
        <el-input
          v-model="form.equipment"
          placeholder="Equipment"
        />
      </el-form-item>
      <el-form-item
        label="Description"
        prop="description"
      >
        <div class="wiziwig">
          <quill-editor
            ref="editor"
            theme="snow"
            v-model:content="form.description"
            contentType="html"
          />
        </div>
      </el-form-item>
      <el-form-item
        label="Youtube URL"
        prop="urlyoutube"
      >
        <el-input
          v-model="form.urlyoutube"
          placeholder="Video ID"
        >
          <template #prepend>https://www.youtube.com/watch?v=</template>
        </el-input>
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

import { useExerciceStore } from '@/store/exerciceStore';
import { useTagStore } from '@/store/tagStore';

export default {
  name: 'AdminPosts',
  setup() {
    const editor = ref(null);
    const formEl = ref(null);
    const exerciceStore = useExerciceStore();
    const tagStore = useTagStore();
    const exercices = computed(() => exerciceStore.exercices);
    const tags = computed(() => tagStore.tags);
    const form = ref({});
    onMounted(() => {
      exerciceStore.getExercices('0');
      tagStore.getTags();
    });
    const handleSubmit = async () => {
      await formEl.value.validate();
      await exerciceStore.createExercice(form.value);
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
      exercices,
    };
  },
};
</script>

<style lang="scss" scoped>
.admin-exercices {
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