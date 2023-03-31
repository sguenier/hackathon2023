import { defineStore } from 'pinia';

export const useProgramStore = defineStore('programStore', {
  state: () => ({
    /**
     * @type {{id: string, name: string}[]}
     */
    programs: [],
    isProgramsLoading: false,
  }),

  actions: {
    async getPrograms() {
      this.isProgramsLoading = true;
      try {
        // uncomment to fake long request for showing app loading
        // await new Promise((resolve) => setTimeout(resolve, 800));
        // const { data } = await $API.get('admin/tag/');
        const data = [
          { id: 1, name: 'Fracure de l\'épaule', time: '15 minutes', image: 'https://placehold.co/400x600' },
          { id: 2, name: 'Fracure de la jambe', time: '30 minutes', image: 'https://placehold.co/400x600' },
          { id: 3, name: 'Fracure de la main', time: '10 minutes', image: 'https://placehold.co/400x600' },
          { id: 4, name: 'Fracure de la tête', time: '45 minutes', image: 'https://placehold.co/400x600' },
        ];
        this.programs = data;
        this.isProgramsLoading = false;
        return data;
      } catch (error) {
        this.isProgramsLoading = false;
        throw error;
      }
    },
  },
});
