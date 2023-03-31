<template>
  <div class="register-care">
    <el-form
      ref="registerCareFrom"
      :label-position="'top'"
      :rules="rules"
      :model="form"
      label-width="170px"
    >
      <el-form-item
        label="Médecin traitant"
        prop="doctor"
      >
        <el-input
          size="large"
          v-model="form.doctor"
          placeholder="Médecin traitant"
        />
      </el-form-item>
      <div class="register-care__group">
        <el-form-item
          label="Taille"
          prop="size"
        >
          <el-input
            type="number"
            native-type="number"
            step="1"
            size="large"
            v-model="form.size"
            placeholder="Taille"
          >
            <template #append>cm</template>
          </el-input>
        </el-form-item>
        <el-form-item
          label="Poids"
          prop="weight"
        >
          <el-input
            type="number"
            step="1"
            size="large"
            v-model="form.weight"
            placeholder="Poids"
          >
            <template #append>kg</template>
          </el-input>
        </el-form-item>
      </div>
      <el-form-item
        label="Pathologies"
        prop="disease"
      >
        <el-checkbox-group v-model="form.disease">
          <el-checkbox
            label="Maladies Cardiovasculaires"
            name="disease"
          />
          <el-checkbox
            label="Cancer"
            name="disease"
          />
          <el-checkbox
            label="Diabète"
            name="disease"
          />
          <el-checkbox
            label="Arthrite"
            name="disease"
          />
          <el-checkbox
            label="Asthme"
            name="disease"
          />
          <el-checkbox
            label="Dépression chronique"
            name="disease"
          />
          <el-checkbox
            label="Autre"
            name="disease"
          />
        </el-checkbox-group>
      </el-form-item>
      <div class="register-care__buttons">
        <el-form-item>
          <el-button
            size="large"
            @click="$emit('previous')"
          >Précedent</el-button>
        </el-form-item>
        <el-form-item>
          <el-button
            type="primary"
            size="large"
            @click="next"
          >Suivant</el-button>
        </el-form-item>
      </div>
    </el-form>
  </div>
</template>

<script>
import {
  ref,
  watch,
} from 'vue';

export default {
  name: 'RegisterCare',
  emits: [
    'next',
    'previous',
    'update:modelValue', 
  ],
  props: {
    modelValue: {
      type: Object,
      default: () => ({}),
    },
  },
  setup(props, { emit }) {
    const form = ref(props.modelValue);
    const registerCareFrom = ref(null);
    watch(
      () => form.value,
      (value) => {
        emit('update:modelValue', value);
      },
    );

    const next = () => {
      registerCareFrom.value.validate((valid) => {
        if (valid) {
          emit('next');
        }
      });
    };

    const rules = ref({
      doctor: [
        {
          required: true,
          message: 'Veuillez votre médecin traitant',
          trigger: 'blur', 
        },
        {
          min: 2,
          max: 20,
          message: 'Le nom doit être compris entre 2 et 20 caractères',
          trigger: 'blur',
        },
      ],
    });

    return {
      next,
      registerCareFrom,
      form,
      rules,
    };
  },
};
</script>

<style lang="scss" scoped>
.register-care {
  padding: 0 48px;

  &__group {
    display: flex;
    gap: 32px;
    justify-content: space-between;
  }

  &__buttons {
    display: flex;
    justify-content: flex-end;
    gap: 16px;
    margin-top: 32px;
  }
}
</style>