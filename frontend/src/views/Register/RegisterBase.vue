<template>
  <div class="register-base">
    <el-form
      ref="registerBaseFrom"
      :label-position="'top'"
      :rules="rules"
      :model="form"
      label-width="170px"
    >
      <el-form-item
        label="Email"
        prop="email"
      >
        <el-input
          size="large"
          v-model="form.email"
          placeholder="Email"
        />
      </el-form-item>
      <el-form-item
        label="Mot de passe"
        prop="pwd"
      >
        <el-input
          size="large"
          v-model="form.pwd"
          type="password"
          autocomplete="off"
          placeholder="Mot de passe"
        />
      </el-form-item>
      <el-form-item
        label="Confirmation du MdP"
        prop="pwdconfirm"
      >
        <el-input
          size="large"
          v-model="form.pwdconfirm"
          type="password"
          autocomplete="off"
          placeholder="Confirmation du mot de passe"
        />
      </el-form-item>
      <div class="register-base__group">
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
  name: 'RegisterBase',
  emits: [ 'next', 'update:modelValue' ],
  props: {
    modelValue: {
      type: Object,
      default: () => ({}),
    },
  },
  setup(props, { emit }) {
    const form = ref(props.modelValue);
    const registerBaseFrom = ref(null);
    watch(
      () => form.value,
      (value) => {
        emit('update:modelValue', value);
      },
    );

    const confirmPasswordValidator = (rule, value, callback) => {
      if (value === '') {
        callback(new Error('Veuillez confirmer le mot de passe'));
      } else if (value !== form.value.pwd) {
        callback(new Error('Les mots de passe ne correspondent pas!'));
      } else {
        callback();
      }
    };

    const next = () => {
      registerBaseFrom.value.validate((valid) => {
        if (valid) {
          emit('next');
        }
      });
    };

    const rules = ref({
      email: [
        {
          required: true,
          message: 'Veuillez renseigner un email',
          trigger: 'blur', 
        },
        {
          type: 'email',
          message: 'Veuillez renseigner un email valide',
          trigger: [ 'blur', 'change' ], 
        },
      ],
      pwd: [
        {
          required: true,
          message: 'Veuillez renseigner un mot de passe',
          trigger: 'blur', 
        },
        {
          min: 6,
          max: 20,
          message: 'Le mot de passe doit faire entre 6 et 20 caractere',
          trigger: 'blur', 
        },
      ],
      pwdconfirm: [
        {
          required: true,
          message: 'Veuillez confirmer le mot de passe',
          trigger: 'blur', 
        },
        {
          validator: confirmPasswordValidator,
          trigger: 'blur', 
        },
      ],
    });

    return {
      next,
      registerBaseFrom,
      form,
      rules,
    };
  },
};
</script>

<style lang="scss" scoped>
.register-base {
  padding: 0 48px;

  &__group {
    display: flex;
    justify-content: flex-end;
  }
}
</style>