// src/plugins/vuetify.ts
import 'vuetify/styles';
import { createVuetify } from 'vuetify';
import * as components from 'vuetify/components';
import * as directives from 'vuetify/directives';
import { aliases, mdi } from 'vuetify/iconsets/mdi';

const vuetify = createVuetify({
  components,
  directives,
  icons: {
    defaultSet: 'mdi',
    aliases,
    sets: {
      mdi,
    },
  },
  theme: {
    defaultTheme: 'light',
    themes: {
      light: {
        colors: {
          gray: '#333333', // グレーの色
          gray30: '#666666', // グレーの色
          primary: '#1E1E1E', // ダークグレー
          tonal: '#FFC107', // Tonalの色
          secondary: '#424242', // ミディアムグレー
          accent: '#FF4081', // アクセントカラー
          error: '#FF5252', // エラーカラー
          info: '#2196F3', // 情報カラー
          success: '#4CAF50', // 成功カラー
          warning: '#FB8C00', // 警告カラー
          background: '#F5F5F5', // 背景色
          surface: '#F5F5F5', // サーフェスカラー
          // yellow: '#FFFF00', // 見やすい黄色
          yellow: '#FFD700', // 暗い黄色
        },
      },
    },
  },
});

export default vuetify;
