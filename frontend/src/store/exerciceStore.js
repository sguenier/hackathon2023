import { defineStore } from 'pinia';
// import $API from '@/plugins/axios';

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
      let data = [];
      if (categorie == '0') {
        // const { data } = await $API.get('exercices/');
        data = [
          {
            id: 1,
            title: 'Exercice 1',
            image: 'https://picsum.photos/200/300',
            content: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed euismod, nisl vel ultricies lacinia, nunc nisl aliquam nisl, vel al',
            categorie: '1',
          },
          {
            id: 2,
            title: 'Exercice 2',
            image: 'https://picsum.photos/200/300',
            content: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed euismod, nisl vel ultricies lacinia, nunc nisl aliquam nisl, vel al',
            categorie: '2',
          },
          {
            id: 3,
            title: 'Exercice 3',
            image: 'https://picsum.photos/200/300',
            content: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed euismod, nisl vel ultricies lacinia, nunc nisl aliquam nisl, vel al',
            categorie: '3',
          },
          {
            id: 4,
            title: 'Exercice 4',
            image: 'https://picsum.photos/200/300',
            content: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed euismod, nisl vel ultricies lacinia, nunc nisl aliquam nisl, vel al',
            categorie: '1',
          },
        ];
      } else {
        // const { data } = await $API.get('posts?categorie=' + categorie);
        data = [
          {
            id: 1,
            title: 'Exercice 1',
            image: 'https://picsum.photos/200/300',
            content: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed euismod, nisl vel ultricies lacinia, nunc nisl aliquam nisl, vel al',
            categorie: '1',
          },
          {
            id: 2,
            title: 'Exercice 2',
            image: 'https://picsum.photos/200/300',
            content: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed euismod, nisl vel ultricies lacinia, nunc nisl aliquam nisl, vel al',
            categorie: '2',
          },
          {
            id: 3,
            title: 'Exercice 3',
            image: 'https://picsum.photos/200/300',
            content: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed euismod, nisl vel ultricies lacinia, nunc nisl aliquam nisl, vel al',
            categorie: '3',
          },
          {
            id: 4,
            title: 'Exercice 4',
            image: 'https://picsum.photos/200/300',
            content: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed euismod, nisl vel ultricies lacinia, nunc nisl aliquam nisl, vel al',
            categorie: '1',
          },
        ];
        //filter data by categorie
        data = data.filter((exercice) => exercice.categorie == categorie);
      }
      await new Promise((resolve) => setTimeout(resolve, 300));
      this.exercices = data;
      this.isExercicesLoading = false;
      return data;
    },

    async getExercice(id) {
      this.isExerciceLoading = true;
      // const { data } = await $API.get('exercices/' + id);
      let data;
      data = [
        {
          id: 1,
          title: 'Exercice 1',
          image: 'https://picsum.photos/200/300',
          content: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed euismod, nisl vel ultricies lacinia, nunc nisl aliquam nisl, vel al. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed euismod, nisl vel ultricies lacinia, nunc nisl aliquam nisl, vel al. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed euismod, nisl vel ultricies lacinia, nunc nisl aliquam nisl, vel al. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed euismod, nisl vel ultricies lacinia, nunc nisl aliquam nisl, vel al. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed euismod, nisl vel ultricies lacinia, nunc nisl aliquam nisl, vel al. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed euismod, nisl vel ultricies lacinia, nunc nisl aliquam nisl, vel al.',
          categorie: '1',
          video: "https://www.youtube.com/embed/Lrl4EWxaT0s",
          duration: 120,
        },
        {
          id: 2,
          title: 'Exercice 2',
          image: 'https://picsum.photos/200/300',
          content: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed euismod, nisl vel ultricies lacinia, nunc nisl aliquam nisl, vel al',
          categorie: '2',
          video: "https://www.youtube.com/watch?v=Lrl4EWxaT0s",
          duration: 420,
        },
        {
          id: 3,
          title: 'Exercice 3',
          image: 'https://picsum.photos/200/300',
          content: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed euismod, nisl vel ultricies lacinia, nunc nisl aliquam nisl, vel al',
          categorie: '3',
          video: "https://www.youtube.com/watch?v=Lrl4EWxaT0s",
          duration: 444,
        },
        {
          id: 4,
          title: 'Exercice 4',
          image: 'https://picsum.photos/200/300',
          content: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed euismod, nisl vel ultricies lacinia, nunc nisl aliquam nisl, vel al',
          categorie: '1',
          video: "https://www.youtube.com/watch?v=Lrl4EWxaT0s",
          duration: 156,
        },
      ];
      data = data.filter((exercice) => exercice.id == id);
      await new Promise((resolve) => setTimeout(resolve, 300));
      this.exercice = data[0];
      this.isExerciceLoading = false;
      return data;
    },


    async getCategories() {
      this.isCategoriesLoading = true;
      // const { data } = await $API.get('categories/');
      const data = [
        {
          id: 0,
          title: 'Tous',
        },
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