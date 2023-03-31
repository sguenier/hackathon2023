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
        data = data.filter((exercice) => exercice.categorie == categorie);
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


    async getCategories() {
      this.isCategoriesLoading = true;
      const { data } = await $API.get('admin/tags/');
      console.log(data);
      await new Promise((resolve) => setTimeout(resolve, 300));
      this.categories = data;
      this.isCategoriesLoading = false;
      return data;
    },
    
    async getCategorie(id) {
      this.isCategorieLoading = true;
      // const { data } = await $API.get('categories/' + id);
      let data = [
        {
          id: 1,
          title: 'Musculation',
        },
        {
          id: 2,
          title: 'Etirement',
        },
        {
          id: 3,
          title: 'Echauffement',
        },
        {
          id: 4,
          title: 'Cardio',
        },
      ];
      data = data.filter((categorie) => categorie.id == id);
      await new Promise((resolve) => setTimeout(resolve, 300));
      this.categorie = data[0];
      this.isCategorieLoading = false;
      return data;
    },
  },
});