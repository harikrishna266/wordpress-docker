import { ComponentFixture, TestBed } from '@angular/core/testing';
import { LayerPatternSettingComponent } from './layer-pattern-setting.component';

describe('LayerPatternSettingComponent', () => {
  let component: LayerPatternSettingComponent;
  let fixture: ComponentFixture<LayerPatternSettingComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      imports: [LayerPatternSettingComponent],
    }).compileComponents();

    fixture = TestBed.createComponent(LayerPatternSettingComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
