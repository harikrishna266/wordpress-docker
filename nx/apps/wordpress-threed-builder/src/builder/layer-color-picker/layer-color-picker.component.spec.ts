import { ComponentFixture, TestBed } from '@angular/core/testing';
import { LayerColorPickerComponent } from './layer-color-picker.component';

describe('LayerOptionsComponent', () => {
  let component: LayerColorPickerComponent;
  let fixture: ComponentFixture<LayerColorPickerComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      imports: [LayerColorPickerComponent],
    }).compileComponents();

    fixture = TestBed.createComponent(LayerColorPickerComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
