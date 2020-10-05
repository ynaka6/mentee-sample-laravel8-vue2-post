import { shallowMount, createLocalVue } from '@vue/test-utils'
import VueRouter from 'vue-router'
import AppLogo from '../AppLogo'

const localVue = createLocalVue()
localVue.use(VueRouter)
const router = new VueRouter()

describe('AppLogo', () => {
    it('props.tagNameにdivを指定した場合、ロゴのImalogが表示される', () => {
        const wrapper = shallowMount(AppLogo, {
            propsData: {
                tagName: 'div',
            },
        })
        expect(wrapper.text()).toBe('Imalog')
    })
    it('props.tagNameにspanを指定した場合、ロゴのImalogが表示される', () => {
        const wrapper = shallowMount(AppLogo, {
            propsData: {
                tagName: 'span',
            },
        })
        expect(wrapper.text()).toBe('Imalog')
    })

    it('props.tagNameにrouter-linkを指定した場合、clickするとトップページへ', () => {
        const wrapper = shallowMount(AppLogo, {
            propsData: {
                tagName: 'router-link',
                to: '/',
            },
            localVue,
            router,
        })
        expect(wrapper.vm.$route.path).toBe('/')
    })
})
