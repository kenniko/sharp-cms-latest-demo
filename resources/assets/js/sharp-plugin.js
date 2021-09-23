import Sharp from "sharp-plugin";
import TextIcon from "./components/TextIcon.vue";
import Title from "./components/Title.vue";

Vue.use(Sharp, {
    customFields: {
        textIcon: TextIcon,
        title: Title,
    },
});
