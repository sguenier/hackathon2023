<template>
  <div class="register-personal">
    <el-form
      ref="registerPersonalFrom"
      class="register-form"
      :label-position="'top'"
      :rules="rules"
      :model="form"
      label-width="170px"
    >
      <el-form-item
        label="Nom"
        prop="lastname"
      >
        <el-input
          size="large"
          v-model="form.lastname"
          placeholder="Nom"
        />
      </el-form-item>
      <el-form-item
        label="Prenom"
        prop="firstname"
      >
        <el-input
          size="large"
          v-model="form.firstname"
          placeholder="Prenom"
        />
      </el-form-item>
      <el-form-item
        label="Date de naissance"
        prop="birthdate"
      >
        <el-date-picker
          v-model="form.birthdate"
          type="date"
          placeholder="Date de naissance"
          size="large"
          value-format="YYYY-MM-DD HH:mm:ss"
        />
      </el-form-item>
      <el-form-item
        label="Sexe"
        prop="sex"
      >
        <el-radio-group
          v-model="form.sex"
          class="ml-4"
        >
          <el-radio
            label="male"
            size="large"
          >Homme</el-radio>
          <el-radio
            label="female"
            size="large"
          >Femme</el-radio>
        </el-radio-group>
      </el-form-item>
      <el-form-item
        label="Numéro de téléphone"
        prop="phonenumber"
      >
        <el-input
          native-type="tel"
          size="large"
          v-model="form.phonenumber"
          placeholder="Numéro de téléphone"
        />
      </el-form-item>
      <el-form-item
        label="Numéro de sécurité social"
        prop="socialsecuritynumber"
      >
        <el-input
          size="large"
          v-model="form.socialsecuritynumber"
          placeholder="Numéro de sécurité social"
        />
      </el-form-item>
      <div class="register-personal__group">
        <el-form-item>
          <el-button
            size="large"
            @click="$emit('previous')"
          >Previous</el-button>
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
  name: 'RegisterBase',
  emits: [
    'previous',
    'next',
    'update:modelValue', 
  ],
  props: {
    modelValue: {
      type: Object,
      default: () => ({}),
    },
  },
  setup(props, { emit }) {
    const registerPersonalFrom = ref(null);
    const form = ref(props.modelValue);
    watch(
      () => form.value,
      (value) => {
        emit('update:modelValue', value);
      },
    );

    const next = () => {
      registerPersonalFrom.value.validate((valid) => {
        if (valid) {
          emit('next');
        }
      });
    };

    const rules = ref({
      lastname: [
        {
          required: true,
          message: 'Veuillez renseigner votre nom',
          trigger: 'blur',
        },
        {
          min: 2,
          max: 30,
          message: 'Le nom doit faire entre 2 et 30 caractere',
          trigger: 'blur',
        },
      ],
      firstname: [
        {
          required: true,
          message: 'Veuillez renseigner votre prenom',
          trigger: 'blur',
        },
        {
          min: 2,
          max: 30,
          message: 'Le prénom doit faire entre 2 et 30 caracteres',
          trigger: 'blur',
        },
      ],
      birthdate: [
        {
          required: true,
          message: 'Veuillez renseigner votre date de naissance',
          trigger: 'blur',
        },
      ],
      sex: [
        {
          required: true,
          message: 'Veuillez renseigner votre sexe',
          trigger: 'blur',
        },
      ],
      phonenumber: [
        {
          required: true,
          message: 'Veuillez renseigner votre numéro de téléphone',
          trigger: 'blur',
        },
        {
          min: 10,
          max: 10,
          message: 'Le numéro de téléphone doit faire 10 chiffres',
          trigger: 'blur',
        },
      ],
      socialsecuritynumber: [
        {
          required: true,
          message: 'Veillez renseigner votre numéro de sécurité social',
          trigger: 'blur',
        },
        {
          patern: /^[0-9]{13}$/,
          message: 'Le numéro de sécurité social doit faire 13 chiffres',
          trigger: 'blur',
        },
      ],
    });

    return {
      form,
      next,
      rules,
      registerPersonalFrom,
    };
  },
};
</script>

<style lang="scss" scoped>
.register-personal {
  padding: 0 48px;

  &__group {
    display: flex;
    justify-content: flex-end;
    gap: 16px;
  }
}
</style>