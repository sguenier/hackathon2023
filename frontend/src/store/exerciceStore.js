import { defineStore } from 'pinia';
import $API from '@/plugins/axios';

export const useExerciceStore = defineStore('exerciceStore', {
  state: () => ({
    exercices: [],
    isExercicesLoading: false,
    exercice: {},
    isExerciceLoading: false,
    categories: [],
    isCategoriesLoading: false,
    categorie: {},
    isCategorieLoading: false,
  }),

  actions: {
    async getExercices(categorie) {
      let { data } = await $API.get('admin/exercices/');
      if (categorie != '0') {
        data = data.filter((exercice) => {
          let found = false;
          exercice.tags.forEach((tag) => {
            if (tag.id == categorie) {
              found = true;
            }
          });
          return found;
        });
      }
      await new Promise((resolve) => setTimeout(resolve, 300));
      this.exercices = data;
      this.isExercicesLoading = false;
      return data;
    },

    async getExercice(id) {
      this.isExerciceLoading = true;
      const { data } = await $API.get(`admin/exercice/${id}/`);
      await new Promise((resolve) => setTimeout(resolve, 300));
      this.exercice = data.exercice;
      this.isExerciceLoading = false;
      return data;
    },
  },
});